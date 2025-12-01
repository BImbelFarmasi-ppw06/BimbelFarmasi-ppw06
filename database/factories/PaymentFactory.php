<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'payment_method' => fake()->randomElement(['bank_transfer', 'ewallet', 'qris', 'midtrans']),
            'amount' => fake()->randomElement([500000, 750000, 1000000, 1500000]),
            'status' => 'pending',
            'proof_url' => fake()->optional()->uuid() . '.jpg',
            'paid_at' => null,
            'rejection_reason' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'paid_at' => null,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'paid_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'rejection_reason' => fake()->sentence(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
        ]);
    }

    public function withProof(): static
    {
        return $this->state(fn (array $attributes) => [
            'proof_url' => fake()->uuid() . '.jpg',
        ]);
    }

    public function withoutProof(): static
    {
        return $this->state(fn (array $attributes) => [
            'proof_url' => null,
        ]);
    }
}
