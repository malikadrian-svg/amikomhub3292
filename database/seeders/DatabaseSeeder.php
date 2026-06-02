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
        // 1. Akun Admin Utama
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name'     => 'Admin Amikom',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]
        );

        // 2. Insert Kategori Event
        $category = \App\Models\Category::firstOrCreate(
            ['slug' => 'seminar-it'],
            ['name' => 'Seminar IT']
        );

        $category2 = \App\Models\Category::firstOrCreate(
            ['slug' => 'entertaiment'],
            ['name' => 'Entertaiment']
        );

        // 3. Insert Sampel Events
        \App\Models\Event::firstOrCreate(
            ['title' => 'Jazz Night 2025'],
            [
                'category_id' => $category2->id,
                'description' => 'Nikmati malam yang indah dengan alunan musik.',
                'date'        => '2026-05-10 19:00:00',
                'location'    => 'Amikom Baru',
                'price'       => 50000,
                'stock'       => 100,
                'poster_path' => 'posters/event-1.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'AI Summit & Expo 2026'],
            [
                'category_id' => $category->id,
                'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence',
                'date'        => '2026-05-01 13:00:00',
                'location'    => 'Ruang Cinema',
                'price'       => 45000,
                'stock'       => 150,
                'poster_path' => 'posters/event-2.png',
            ]
        );
    }
}
