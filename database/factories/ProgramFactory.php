<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        $name = fake()->randomElement([
            'Bimbel UKOM D3 Farmasi',
            'CPNS & P3K Farmasi',
            'Joki Tugas Farmasi',
            'Bimbel Apoteker',
        ]) . ' - ' . fake()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(15),
            'price' => fake()->randomElement([500000, 750000, 1000000, 1500000]),
            'duration_months' => fake()->numberBetween(1, 6),
            'total_sessions' => fake()->numberBetween(8, 24),
            'type' => fake()->randomElement(['bimbel', 'joki']),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function joki(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'joki',
            'duration_months' => null,
            'total_sessions' => null,
        ]);
    }
}
