<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Nutricionista',
            'email'    => 'admin@mealplanner.test',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Usuario',
            'email'    => 'member@mealplanner.test',
            'password' => Hash::make('password'),
            'role'     => 'member',
        ]);
    }
}
