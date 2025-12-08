<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'email' => 'admin@bimbelfarmasi.com',
            'is_admin' => true,
        ]);
        
        $this->regularUser = User::factory()->create([
            'is_admin' => false,
        ]);

        Storage::fake('payment_proofs');
    }

    public function test_admin_can_view_payments_list(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin/payments');

        $response->assertStatus(200);
        $response->assertViewIs('admin.payments.index');
    }

    public function test_regular_user_cannot_access_admin_payments(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/admin/payments');

        $response->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_payments(): void
    {
        $response = $this->get('/admin/payments');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_payment_details(): void
    {
        $order = Order::factory()->create();
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get("/admin/payments/{$payment->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.payments.show');
        $response->assertViewHas('payment', $payment);
    }

    public function test_admin_can_approve_payment(): void
    {
        $order = Order::factory()->create(['status' => 'waiting_verification']);
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post("/admin/payments/{$payment->id}/approve");

        $response->assertRedirect('/admin/payments');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);

        // Check that paid_at timestamp was set
        $payment->refresh();
        $this->assertNotNull($payment->paid_at);
    }

    public function test_admin_can_reject_payment_with_reason(): void
    {
        $order = Order::factory()->create(['status' => 'waiting_verification']);
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post("/admin/payments/{$payment->id}/reject", [
                'rejection_reason' => 'Bukti pembayaran tidak jelas',
            ]);

        $response->assertRedirect('/admin/payments');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'rejected',
            'rejection_reason' => 'Bukti pembayaran tidak jelas',
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'rejected',
        ]);
    }

    public function test_reject_payment_requires_rejection_reason(): void
    {
        $payment = Payment::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin, 'admin')
            ->post("/admin/payments/{$payment->id}/reject", [
                'rejection_reason' => '',
            ]);

        $response->assertSessionHasErrors('rejection_reason');
    }

    public function test_admin_can_view_payment_proof_image(): void
    {
        $file = UploadedFile::fake()->image('proof.jpg');
        $filePath = $file->store('', 'payment_proofs');
        
        $order = Order::factory()->create();
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'proof_url' => $filePath,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get("/admin/payments/{$payment->id}/proof");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/jpeg');
    }

    public function test_regular_user_cannot_view_payment_proof_via_admin_route(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->actingAs($this->regularUser)
            ->get("/admin/payments/{$payment->id}/proof");

        $response->assertRedirect('/admin/login');
    }

    public function test_cannot_approve_already_approved_payment(): void
    {
        $payment = Payment::factory()->create(['status' => 'approved']);

        $response = $this->actingAs($this->admin, 'admin')
            ->post("/admin/payments/{$payment->id}/approve");

        // Should not change status or return error
        $payment->refresh();
        $this->assertEquals('approved', $payment->status);
    }

    public function test_payments_list_shows_pending_payments(): void
    {
        Payment::factory()->count(3)->create(['status' => 'pending']);
        Payment::factory()->count(2)->create(['status' => 'approved']);

        $response = $this->actingAs($this->admin, 'admin')->get('/admin/payments');

        $response->assertStatus(200);
        $response->assertViewHas('payments');
    }

    public function test_admin_can_filter_payments_by_status(): void
    {
        Payment::factory()->count(5)->create(['status' => 'pending']);
        Payment::factory()->count(3)->create(['status' => 'approved']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/admin/payments?status=pending');

        $response->assertStatus(200);
    }

    public function test_payment_approval_updates_order_status(): void
    {
        $order = Order::factory()->create([
            'status' => 'waiting_verification',
            'amount' => 500000,
        ]);
        
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin, 'admin')
            ->post("/admin/payments/{$payment->id}/approve");

        $order->refresh();
        $this->assertEquals('processing', $order->status);
    }

    public function test_payment_rejection_updates_order_status(): void
    {
        $order = Order::factory()->create(['status' => 'waiting_verification']);
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin, 'admin')
            ->post("/admin/payments/{$payment->id}/reject", [
                'rejection_reason' => 'Invalid proof',
            ]);

        $order->refresh();
        $this->assertEquals('rejected', $order->status);
    }

    public function test_admin_login_has_rate_limiting(): void
    {
        // Attempt login 6 times (limit is 5 per minute)
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/admin/login', [
                'email' => 'admin@test.com',
                'password' => 'wrong-password',
            ]);
        }

        // 6th attempt should be rate limited
        $response->assertStatus(429);
    }
}
