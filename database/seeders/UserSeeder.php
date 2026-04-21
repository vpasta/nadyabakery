<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::where('username', 'kasir')->delete();

        User::create([
            'name' => 'Kasir Nadya Bakery',
            'username' => 'kasir',
            'password' => Hash::make('12345678'), 
        ]);
    }
}