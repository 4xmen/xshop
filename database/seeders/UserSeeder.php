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
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(1)->create(['email' => 'admin@example.com']);
        $role = Role::create(['name' => 'super-admin']);
        $superAdmin = User::where('id',1)->first()->assignRole($role);

    }
}
