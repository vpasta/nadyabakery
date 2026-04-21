<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar tidak undefined
use Illuminate\Support\Facades\Storage;
use App\Models\Kategori;

class SettingsController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        $kategori = Kategori::all(); 
        
        // Pastikan user ada (untuk menghindari error undefined)
        if (!$user) {
            return redirect('/login');
        }

        return view('bakery-settings', compact('user', 'kategori'));
    }

    public function updateProfile(Request $request)
    {
        // Simpan ID user ke dalam variabel menggunakan Facade Auth
        $userId = \Illuminate\Support\Facades\Auth::id();

        // 1. Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'password' => 'nullable|string|min:8|confirmed', // 'confirmed' otomatis mengecek field password_confirmation
        ]);

        try {
            // Beritahu Intelephense bahwa ini adalah model User
            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            
            // 2. Siapkan data yang akan diupdate (Username selalu diupdate)
            $updateData = [
                'username' => $request->username,
            ];

            // 3. Jika field password diisi, maka enkripsi dan masukkan ke data update
            if ($request->filled('password')) {
                $updateData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            // 4. Proses Update
            $user->update($updateData);

            return back()->with('success', 'Akun berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    public function updateQris(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('qris_image')) {
            // Simpan gambar ke public/images/qris.png (timpa file lama)
            $request->file('qris_image')->storeAs('images', 'qris.png', 'public');
            
            return back()->with('success', 'Gambar QRIS berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori']);
        Kategori::create(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255']);
        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}