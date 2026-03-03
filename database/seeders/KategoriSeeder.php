<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create(['nama_kategori' => 'Roti Manis']);
        Kategori::create(['nama_kategori' => 'Cake']);
        Kategori::create(['nama_kategori' => 'Pastry']);
        Kategori::create(['nama_kategori' => 'Minuman']);
    }
}
