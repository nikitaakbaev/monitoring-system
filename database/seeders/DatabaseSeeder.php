<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::create([
            'role_name' => 'Админ',
        ]);

        Role::create([
            'role_name' => 'Учитель',
        ]);

        Role::create([
            'role_name' => 'Родитель',
        ]);

        User::create([
            'first_name' => 'Акбаев',
            'middle_name' => 'Никита',
            'last_name' => 'Алексеевич',
            'birth_date' => '2004.09.19',
            'email' => 'test@example.com',
            'phone' => '',
            'address' => '',
            'password' => 'AdOa2839!',
            'roleID' => 1,
            'is_active' => true,
        ]);
    }
}
