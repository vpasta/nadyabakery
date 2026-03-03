<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            // Produk 1 (Pastry - ID: 3)
            Produk::create([
                'kategori_id' => 3, 
                'nama_produk' => 'Butter Croissant',
                'deskripsi' => 'Renyah di luar, lembut di dalam dengan mentega premium.',
                'harga' => 25000,
                'stok' => 50,
                'gambar' => 'https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?auto=format&fit=crop&w=400&q=80'
            ]);
    
            // Produk 2 (Cake - ID: 2)
            Produk::create([
                'kategori_id' => 2,
                'nama_produk' => 'Strawberry Cupcake',
                'deskripsi' => 'Cupcake vanila dengan frosting stroberi segar.',
                'harga' => 18000,
                'stok' => 30,
                'gambar' => 'https://images.unsplash.com/photo-1587668178277-295251f900ce?auto=format&fit=crop&w=400&q=80'
            ]);
    
            // Produk 3 (Cake - ID: 2)
            Produk::create([
                'kategori_id' => 2,
                'nama_produk' => 'Blueberry Cheesecake',
                'deskripsi' => 'Cheesecake lumer dengan topping selai blueberry.',
                'harga' => 35000,
                'stok' => 20,
                'gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=400&q=80'
            ]);
    
            // Produk 4 (Roti Manis - ID: 1)
            Produk::create([
                'kategori_id' => 1,
                'nama_produk' => 'Roti Tawar Gandum',
                'deskripsi' => 'Roti tawar sehat kaya serat.',
                'harga' => 22000,
                'stok' => 40,
                'gambar' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=400&q=80'
            ]);
        }
    }
}
