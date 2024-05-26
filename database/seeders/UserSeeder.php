<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        // add roles
        foreach (User::$roles as $role) {
            $r = new Role();
            $r->name = strtolower($role);
            $r->save();
        }

        $developer = User::whereId(1)->first();
        $developer->assignRole('developer');
        $developer->save();

        $admin = User::whereId(2)->first();
        $admin->assignRole('admin');
        $admin->save();

        $user = User::whereId(3)->first();
        $user->assignRole('user');
        $user->save();

        User::factory(50)->create();

    }
}
