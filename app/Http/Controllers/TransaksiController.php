<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function prosesCheckout(Request $request)
    {
        $keranjang = $request->keranjang;
        $metode = $request->metode_pembayaran ?? 'Tunai';

        if (empty($keranjang)) {
            return response()->json(['success' => false, 'message' => 'Keranjang masih kosong.']);
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($keranjang as $item) {
                $subtotal += $item['harga'] * $item['qty'];
            }
            
            // Pajak dihapus sesuai permintaan sebelumnya
            $total_bayar = $subtotal;

            // 1. Simpan Transaksi Utama
            $transaksiBaru = Transaksi::create([
                'nomor_nota' => 'NDY-' . time(), 
                'nama_kasir' => 'Kasir Nadya', 
                'total_harga' => $subtotal,
                'pajak' => 0,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => ucfirst($metode) 
            ]);

            // 2. Simpan Detail & Kurangi Stok
            foreach ($keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksiBaru->id,
                    'produk_id' => $item['id'],
                    'jumlah_beli' => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty']
                ]);

                // Logika Pengurangan Stok
                $produk = Produk::find($item['id']);
                if ($produk) {
                    $produk->stok -= $item['qty'];
                    $produk->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true, 
                'pesan' => 'Pembayaran berhasil!',
                'nota' => $transaksiBaru->nomor_nota
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Fungsi Hapus 1 Riwayat
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::with('detailTransaksi')->findOrFail($id);
            if ($request->restore_stock == 'true') {
                foreach ($transaksi->detailTransaksi as $detail) {
                    $produk = Produk::find($detail->produk_id);
                    if ($produk) {
                        $produk->stok += $detail->jumlah_beli;
                        $produk->save();
                    }
                }
            }
            $transaksi->detailTransaksi()->delete();
            $transaksi->delete();

            DB::commit();
            return back()->with('success', 'Riwayat transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // Fungsi Hapus Banyak (Terpilih)
    public function destroyBulk(Request $request)
    {
        $ids = explode(',', $request->ids);
        $restore = $request->restore_stock == 'true';

        DB::beginTransaction();
        try {
            $transaksis = Transaksi::with('detailTransaksi')->whereIn('id', $ids)->get();
            foreach ($transaksis as $transaksi) {
                if ($restore) {
                    foreach ($transaksi->detailTransaksi as $detail) {
                        $produk = Produk::find($detail->produk_id);
                        if ($produk) {
                            $produk->stok += $detail->jumlah_beli;
                            $produk->save();
                        }
                    }
                }
                $transaksi->detailTransaksi()->delete();
                $transaksi->delete();
            }
            DB::commit();
            return back()->with('success', count($ids) . ' Riwayat transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus terpilih: ' . $e->getMessage());
        }
    }

    // Fungsi Hapus Semua Riwayat
    public function destroyAll(Request $request)
    {
        $restore = $request->restore_stock == 'true';

        DB::beginTransaction();
        try {
            if ($restore) {
                $transaksis = Transaksi::with('detailTransaksi')->get();
                foreach ($transaksis as $transaksi) {
                    foreach ($transaksi->detailTransaksi as $detail) {
                        $produk = Produk::find($detail->produk_id);
                        if ($produk) {
                            $produk->stok += $detail->jumlah_beli;
                            $produk->save();
                        }
                    }
                }
            }
            
            // Hapus semua data
            DetailTransaksi::query()->delete();
            Transaksi::query()->delete();

            DB::commit();
            return back()->with('success', 'Semua riwayat transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus semua: ' . $e->getMessage());
        }
    }

    // Fungsi Menampilkan Halaman Riwayat (Dibatasi 10 Per Halaman)
    public function riwayat()
    {
        $transaksis = Transaksi::with(['detailTransaksi.produk'])
                               ->orderBy('created_at', 'desc')
                               ->paginate(10); // <-- Di sini letak pembatasan 10 tabel
        return view('bakery-history', compact('transaksis'));
    }
}