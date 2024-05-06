<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // developer
        User::factory()->create(
            [
                'name' => 'WebDeveloper',
                'email' => 'developer@example.com',
                'role'=> 'DEVELOPER',
            ]
        );
        // website admin
        User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role'=> 'ADMIN',
            ]
        );
        // website user
        User::factory()->create(
            [
                'name' => 'ManagerUser',
                'email' => 'user@example.com',
            ]
        );
    }
}
