<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua user yang ada
        User::truncate();

        // Buat satu-satunya user admin
        User::create([
            'name' => 'Admin Mekarjaya',
            'email' => 'adminmekarjaya@gmail.com',
            'password' => bcrypt('jalanmekarbaru'),
        ]);
    }
}
