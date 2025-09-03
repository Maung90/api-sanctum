<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['role' => 'master', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'pegawai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
