<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function prosesCheckout(Request $request)
    {
        // 1. Ambil data keranjang yang dikirim dari JavaScript
        $keranjang = $request->keranjang;

        // Jika kosong, tolak prosesnya
        if (empty($keranjang)) {
            return response()->json(['success' => false, 'message' => 'Keranjang masih kosong.']);
        }

        // Kita gunakan DB::transaction agar jika terjadi error di tengah jalan, 
        // data tidak tersimpan setengah-setengah.
        DB::beginTransaction();

        try {
            // 2. Hitung ulang total belanja di server (demi keamanan)
            $subtotal = 0;
            foreach ($keranjang as $item) {
                $subtotal += $item['harga'] * $item['qty'];
            }
            $pajak = $subtotal * 0.10; // Pajak 10%
            $total_bayar = $subtotal + $pajak;

            // 3. Simpan ke tabel `transaksi`
            $transaksiBaru = Transaksi::create([
                // Membuat nomor nota otomatis, cth: TRX-1715421234
                'nomor_nota' => 'NDY-' . time(), 
                'nama_kasir' => 'Kasir Nadya', // Sementara kita tulis manual
                'total_harga' => $subtotal,
                'pajak' => $pajak,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => 'Tunai' // Default tunai
            ]);

            // 4. Simpan isi keranjang ke tabel `detail_transaksi`
            foreach ($keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksiBaru->id,
                    'produk_id' => $item['id'],
                    'jumlah_beli' => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty']
                ]);
            }

            // Jika semua lancar, simpan permanen ke database
            DB::commit();

            // Beri jawaban sukses ke JavaScript
            return response()->json([
                'success' => true, 
                'pesan' => 'Pembayaran berhasil!',
                'nota' => $transaksiBaru->nomor_nota
            ]);

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua proses simpan
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
    // Fungsi untuk menampilkan halaman riwayat transaksi
    public function riwayat()
    {
        // Ambil semua data transaksi, urutkan dari yang terbaru (descending)
        $transaksis = Transaksi::orderBy('created_at', 'desc')->get();
        
        // Kirim data tersebut ke view 'bakery-history'
        return view('bakery-history', compact('transaksis'));
    }
}