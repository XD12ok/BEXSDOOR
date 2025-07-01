<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $userData = [
            [
                'name' =>'Admin',
                'email' =>'Admin@gmail.com',
                'role' =>'admin',
                'password' => bcrypt('Admin'),

            ],
            [
                'name' =>'User',
                'email' =>'User@gmail.com',
                'role' =>'user',
                'password' => bcrypt('User'),
            ]
        ];

        foreach ($userData as $key=>$val) {
            User::create($val);
        }

    }
}
