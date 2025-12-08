<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_orders_api(): void
    {
        $response = $this->getJson('/api/orders');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_authenticated_user_can_get_their_orders(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $orders = Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'order_number',
                    'user_id',
                    'program_id',
                    'amount',
                    'status',
                    'created_at',
                ],
            ],
        ]);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_only_see_their_own_orders(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Order::factory()->count(2)->create(['user_id' => $user1->id]);
        Order::factory()->count(3)->create(['user_id' => $user2->id]);

        Sanctum::actingAs($user1);
        $response = $this->getJson('/api/orders');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_authenticated_user_can_create_order_via_api(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create(['price' => 750000]);
        
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/orders', [
            'program_id' => $program->id,
            'notes' => 'API created order',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'order_number',
                'user_id',
                'program_id',
                'amount',
                'status',
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'program_id' => $program->id,
            'amount' => 750000,
            'notes' => 'API created order',
        ]);
    }

    public function test_create_order_api_validates_required_fields(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/orders', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['program_id']);
    }

    public function test_create_order_api_validates_program_exists(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/orders', [
            'program_id' => 99999, // Non-existent
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['program_id']);
    }

    public function test_authenticated_user_can_get_single_order(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);
        $response = $this->getJson("/api/orders/{$order->order_number}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'order_number' => $order->order_number,
                'user_id' => $user->id,
            ],
        ]);
    }

    public function test_user_cannot_get_another_users_order(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $order = Order::factory()->create(['user_id' => $user2->id]);

        Sanctum::actingAs($user1);
        $response = $this->getJson("/api/orders/{$order->order_number}");

        $response->assertStatus(404);
    }

    public function test_api_returns_proper_error_for_invalid_order_number(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/orders/INVALID-ORDER-123');

        $response->assertStatus(404);
    }

    public function test_orders_api_includes_program_relationship(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create(['name' => 'Test Program']);
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'program_id' => $program->id,
        ]);

        Sanctum::actingAs($user);
        $response = $this->getJson("/api/orders/{$order->order_number}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'program' => [
                    'id',
                    'name',
                    'price',
                ],
            ],
        ]);
        $response->assertJson([
            'data' => [
                'program' => [
                    'name' => 'Test Program',
                ],
            ],
        ]);
    }

    public function test_orders_api_includes_payment_relationship(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        
        // Assuming Payment factory and relationship exists
        // Payment::factory()->create(['order_id' => $order->id, 'status' => 'paid']);

        Sanctum::actingAs($user);
        $response = $this->getJson("/api/orders/{$order->order_number}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'order_number',
                'payment', // Can be null or object
            ],
        ]);
    }
}
