<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@foodpark.com',
                'password' => Hash::make('!P@ssw0rd#'),
                'role' => 'admin'
            ],
            [
                'name' => 'Huu Dai',
                'email' => 'dainguyen@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user'

            ],
        ]);
    }
}
