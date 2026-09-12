<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // CategorySeeder ko yaha call karein
        $this->call([
            CategorySeeder::class,
        ]);
    }
}