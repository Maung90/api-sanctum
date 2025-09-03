<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        Bidang::insert([
            ['bidang' => 'Teknologi Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['bidang' => 'Keuangan', 'created_at' => now(), 'updated_at' => now()],
            ['bidang' => 'Sumber Daya Manusia', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
