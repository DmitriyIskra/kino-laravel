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
    
     //login: test@example.com
     // pass: qwerty
 
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->create([
            'email' => 'test@example.com',
            'is_admin' => 1,
            'password' => 'qwerty',
        ]);
    }
}
