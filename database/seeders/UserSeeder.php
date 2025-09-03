<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'nip' => '123456',
                'nama_lengkap' => 'Super Master',
                'email' => 'master@example.com',
                'password' => Hash::make('password'), 
                'role_id' => 1,
                'bidang_id' => 1,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '654321',
                'nama_lengkap' => 'Admin Rapat',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, 
                'bidang_id' => 2,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '789012',
                'nama_lengkap' => 'Pegawai Satu',
                'email' => 'pegawai@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'bidang_id' => 3,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
