<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        \App\Models\User::create([
            'name' => 'Kasir',
            'email' => 'kasir@kasir.com',
            'password' => bcrypt('password'),
            'role' => 'kasir'
        ]);

        \App\Models\User::create([
            'name' => 'Owner',
            'email' => 'owner@owner.com',
            'password' => bcrypt('password'),
            'role' => 'owner'
        ]);
    }
}
