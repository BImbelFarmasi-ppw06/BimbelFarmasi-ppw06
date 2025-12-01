<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => $this->generateOrderNumber(),
            'user_id' => User::factory(),
            'program_id' => Program::factory(),
            'amount' => fake()->randomElement([500000, 750000, 1000000, 1500000]),
            'status' => fake()->randomElement(['pending', 'waiting_verification', 'processing', 'completed']),
            'notes' => fake()->optional()->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(fake()->bothify('??###'));
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function waitingVerification(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'waiting_verification',
        ]);
    }

    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processing',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
