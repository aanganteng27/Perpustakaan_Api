<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run()
    {
        // Menggunakan updateOrCreate agar jika data sudah ada, 
        // role dan is_active akan diperbarui tanpa membuat data ganda.
        User::updateOrCreate(
            ['email' => 'ainanhammal@example.com'], // Kunci pencarian berdasarkan email
            [
                'name'      => 'Ainan Hammal',
                'password'  => Hash::make('12345678'),
                'role'      => 'admin',     // Memberikan hak akses Admin
                'is_active' => true,        // Admin otomatis aktif tanpa approval
            ]
        );
    }
}