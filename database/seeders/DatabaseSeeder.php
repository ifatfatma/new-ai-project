<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Default Admin User Create Karein
        User::updateOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        // 2. CategorySeeder Call Karein
        $this->call([
            CategorySeeder::class,
        ]);
    }
}