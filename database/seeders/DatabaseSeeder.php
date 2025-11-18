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
        // Seed programs and admin
        $this->call([
            AdminSeeder::class,
            ProgramSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
