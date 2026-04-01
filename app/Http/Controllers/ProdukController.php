<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use illuminate\Support\Str;

class ProdukController extends Controller
{
    // 1. Read (Menampilkan halaman stok)
    public function index()
    {
        // Ambil data produk beserta data kategorinya (jika ada relasi)
        $produks = Produk::all();
        $kategoris = Kategori::all(); // Untuk pilihan di form tambah/edit
        
        return view('bakery-stok', compact('produks', 'kategoris'));
    }

    // 2. Create (Menyimpan produk baru)
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi khusus gambar (maksimal 2MB)
        ]);

        // Cek apakah ada file gambar yang diupload
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder 'public/produk'
            $pathGambar = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'gambar' => $pathGambar // Simpan path (teks)-nya saja ke database
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // 3. Update (Menyimpan perubahan produk)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produk = Produk::findOrFail($id);

        // Data dasar yang akan diupdate
        $dataUpdate = [
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ];

        // Jika user mengupload gambar baru saat edit
        if ($request->hasFile('gambar')) {
            // Simpan gambar baru
            $dataUpdate['gambar'] = $request->file('gambar')->store('produk', 'public');
            
            // Catatan: Idealnya kita menghapus file gambar lama di sini pakai Storage::delete()
            // Tapi untuk sekarang kita simpan barunya saja agar lebih simpel
        }

        $produk->update($dataUpdate);

        return back()->with('success', 'Data produk berhasil diperbarui!');
    }

    // 4. Delete (Menghapus produk)
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}