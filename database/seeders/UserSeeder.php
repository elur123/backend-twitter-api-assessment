<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jhon Doe',
            'username' => 'jhon',
            'email' => 'jhon@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'name' => 'User Guest',
            'username' => 'guest',
            'email' => 'guest@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
