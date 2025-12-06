<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed programs and admin only (disable testimonial seeder)
        $this->call([
            AdminSeeder::class,
            ProgramSeeder::class,
            // TestimonialSeeder::class, // Commented out - creates sample users
        ]);
    }
}
