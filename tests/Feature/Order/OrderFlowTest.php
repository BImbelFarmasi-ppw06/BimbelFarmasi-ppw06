<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('payment_proofs');
    }

    public function test_authenticated_user_can_view_order_form(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create([
            'slug' => 'test-program',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get("/order/{$program->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('pages.order.create');
        $response->assertViewHas('program', $program);
    }

    public function test_guest_cannot_create_order(): void
    {
        $program = Program::factory()->create();

        $response = $this->post('/order', [
            'program_id' => $program->id,
            'notes' => 'Test notes',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_order(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create(['price' => 500000]);

        $response = $this->actingAs($user)->post('/order', [
            'program_id' => $program->id,
            'notes' => 'Please schedule for weekends',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'program_id' => $program->id,
            'amount' => 500000,
            'status' => 'pending',
            'notes' => 'Please schedule for weekends',
        ]);

        $order = Order::where('user_id', $user->id)->first();
        $response->assertRedirect("/order/{$order->order_number}/payment");
    }

    public function test_order_creation_fails_with_invalid_program(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/order', [
            'program_id' => 99999, // Non-existent program
            'notes' => 'Test notes',
        ]);

        $response->assertSessionHasErrors('program_id');
    }

    public function test_order_number_is_unique(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();

        // Create two orders
        $this->actingAs($user)->post('/order', [
            'program_id' => $program->id,
        ]);

        $this->actingAs($user)->post('/order', [
            'program_id' => $program->id,
        ]);

        $orders = Order::where('user_id', $user->id)->get();
        
        $this->assertCount(2, $orders);
        $this->assertNotEquals($orders[0]->order_number, $orders[1]->order_number);
    }

    public function test_user_can_upload_payment_proof(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $file = UploadedFile::fake()->image('proof.jpg', 800, 600)->size(1024); // 1MB

        $response = $this->actingAs($user)->post("/order/{$order->order_number}/payment", [
            'payment_method' => 'bank_transfer',
            'proof' => $file,
        ]);

        $response->assertRedirect("/order/{$order->order_number}/success");
        
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'payment_method' => 'bank_transfer',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'waiting_verification',
        ]);

        // Verify file was stored
        $payment = Payment::where('order_id', $order->id)->first();
        Storage::disk('payment_proofs')->assertExists($payment->proof_url);
    }

    public function test_payment_upload_fails_without_proof_file(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post("/order/{$order->order_number}/payment", [
            'payment_method' => 'bank_transfer',
        ]);

        $response->assertSessionHasErrors('proof');
    }

    public function test_payment_upload_fails_with_invalid_file_type(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->create('document.pdf', 500);

        $response = $this->actingAs($user)->post("/order/{$order->order_number}/payment", [
            'payment_method' => 'bank_transfer',
            'proof' => $file,
        ]);

        $response->assertSessionHasErrors('proof');
    }

    public function test_payment_upload_fails_with_oversized_file(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->image('huge.jpg')->size(3072); // 3MB (over 2MB limit)

        $response = $this->actingAs($user)->post("/order/{$order->order_number}/payment", [
            'payment_method' => 'bank_transfer',
            'proof' => $file,
        ]);

        $response->assertSessionHasErrors('proof');
    }

    public function test_payment_upload_has_rate_limiting(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->image('proof.jpg');

        // Attempt upload 11 times (limit is 10 per minute)
        for ($i = 0; $i < 11; $i++) {
            $response = $this->actingAs($user)->post("/order/{$order->order_number}/payment", [
                'payment_method' => 'bank_transfer',
                'proof' => $file,
            ]);
        }

        // 11th attempt should be rate limited
        $response->assertStatus(429);
    }

    public function test_user_can_view_their_own_payment_proof(): void
    {
        Storage::fake('payment_proofs');
        
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        
        $file = UploadedFile::fake()->image('proof.jpg');
        $filePath = $file->store('', 'payment_proofs');
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'proof_url' => $filePath,
        ]);

        $response = $this->actingAs($user)->get("/order/{$order->order_number}/payment-proof");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/jpeg');
    }

    public function test_user_cannot_view_other_users_payment_proof(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $order = Order::factory()->create(['user_id' => $user1->id]);
        Payment::factory()->create(['order_id' => $order->id]);

        $response = $this->actingAs($user2)->get("/order/{$order->order_number}/payment-proof");

        $response->assertStatus(404);
    }

    public function test_guest_cannot_view_payment_proof(): void
    {
        $order = Order::factory()->create();
        Payment::factory()->create(['order_id' => $order->id]);

        $response = $this->get("/order/{$order->order_number}/payment-proof");

        $response->assertRedirect('/login');
    }

    public function test_user_can_view_their_orders(): void
    {
        $user = User::factory()->create();
        
        $orders = Order::factory()
            ->count(3)
            ->create(['user_id' => $user->id]);
        
        foreach ($orders as $order) {
            Payment::factory()->create(['order_id' => $order->id]);
        }

        $response = $this->actingAs($user)->get('/pesanan-saya');

        $response->assertStatus(200);
        $response->assertViewIs('pages.order.my-orders');
        $response->assertViewHas('orders');
    }
}
