<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Riwayat - Nadya Bakery</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#F58E8B">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-dark h-screen w-full flex overflow-hidden">
    <aside id="sidebar-menu" class="fixed md:static top-0 left-0 h-full w-64 shrink-0 bg-white border-r border-primary-soft flex flex-col justify-between shadow-2xl md:shadow-none z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div>
            <div class="h-20 flex items-center justify-between px-6 border-b border-pink-50">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-14 h-14 mb-2 block">
                    <span class="ml-1 font-bold text-primary text-xl">Nadya Bakery</span>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500 transition">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>

            <nav class="p-4 space-y-2">
                <a href="/kasir" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-white bg-primary rounded-xl shadow-lg shadow-primary-soft transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
                </a>
                <a href="/pengaturan" class="flex items-center p-3 {{ Request::is('pengaturan') ? 'text-white bg-primary rounded-xl shadow-lg' : 'text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl' }} transition">
                    <i class="ph ph-gear text-2xl"></i>
                    <span class="ml-3 font-medium">Pengaturan</span>
                </a>
            </nav>
        </div>

        <div class="p-4">
            <a href="/logout" class="flex items-center p-3 text-red-400 hover:bg-red-50 rounded-xl transition">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="ml-3 font-medium">Keluar</span>
            </a>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
        <header class="py-4 md:h-20 bg-white border-b border-gray-100 px-4 md:px-8 flex items-center justify-between shadow-sm z-10 shrink-0">
            <div class="flex items-center gap-3 md:gap-0">
                <button onclick="toggleSidebar()" class="md:hidden text-gray-500 bg-gray-100 hover:bg-pink-100 hover:text-primary p-2 rounded-lg transition">
                    <i class="ph ph-list text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">Riwayat Penjualan</h1>
                    <p class="text-xs text-gray-400 hidden md:block">Daftar semua transaksi Nadya Bakery</p>
                </div>
            </div>
            <div class="bg-pink-50 text-primary px-3 md:px-4 py-2 rounded-xl font-bold text-xs md:text-sm border border-primary-soft">
                <span class="hidden md:inline">Total Transaksi: </span>
                <span class="md:hidden">Total: </span>
                {{ $transaksis->total() }} {{-- Gunakan total() karena sekarang memakai paginasi --}}
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            
            {{-- Tombol Aksi Massal --}}
            <div class="mb-4 flex flex-wrap gap-2 justify-end">
                <button id="btn-hapus-terpilih" onclick="konfirmasiHapusBulk()" class="hidden bg-orange-100 text-orange-600 hover:bg-orange-200 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                    <i class="ph ph-trash"></i> Hapus Terpilih
                </button>
                @if($transaksis->count() > 0)
                <button onclick="konfirmasiHapusSemua()" class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                    <i class="ph ph-warning"></i> Kosongkan Semua Riwayat
                </button>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-primary-soft overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-150">
                        <thead>
                            <tr class="bg-bg text-primary border-b border-primary-soft">
                                <th class="py-4 px-4 w-10 text-center">
                                    <input type="checkbox" id="check-all" onclick="toggleSemuaCheckbox(this)" class="w-4 h-4 text-primary rounded focus:ring-primary">
                                </th>
                                <th class="py-4 px-2 md:px-6 font-semibold text-sm">No. Nota</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">Tanggal & Waktu</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">Metode</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-right">Total Belanja</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        
                        @if($transaksis->isEmpty())
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Belum ada transaksi saat ini.</td>
                            </tr>
                        @endif

                        @foreach($transaksis as $trx)
                            <tr class="hover:bg-pink-50/50 transition duration-150 group">
                                <td class="py-4 px-4 text-center">
                                    <input type="checkbox" class="checkbox-riwayat w-4 h-4 text-primary rounded focus:ring-primary" value="{{ $trx->id }}" onchange="periksaCheckbox()">
                                </td>
                                <td class="py-4 px-2 md:px-6 font-bold text-gray-700">
                                    {{ $trx->nomor_nota }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-4 md:px-6">
                                    @if(strtolower($trx->metode_pembayaran) == 'qris')
                                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="ph ph-qr-code mr-1"></i> QRIS
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="ph ph-money mr-1"></i> Tunai
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 md:px-6 font-bold text-primary text-right">
                                    Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-center flex justify-center gap-2">
                                    
                                    {{-- Data yang dikirim ke JS untuk cetak ulang nota --}}
                                    @php
                                        $printData = [
                                            'nota' => $trx->nomor_nota,
                                            'kasir' => $trx->nama_kasir,
                                            'total' => $trx->total_bayar,
                                            'items' => $trx->detailTransaksi->map(function($dt) {
                                                return [
                                                    'nama' => $dt->produk->nama_produk ?? 'Produk Terhapus',
                                                    'qty' => $dt->jumlah_beli,
                                                    'harga' => $dt->harga_satuan,
                                                ];
                                            })
                                        ];
                                    @endphp

                                    <button onclick="cetakNotaRiwayat({{ json_encode($printData) }})" title="Cetak Ulang Nota"
                                            class="text-blue-400 hover:text-blue-600 transition p-2 rounded bg-white shadow-sm border border-gray-100">
                                        <i class="ph ph-printer text-lg"></i>
                                    </button>

                                    <button onclick="document.getElementById('modal-trx-{{ $trx->id }}').classList.remove('hidden')" title="Lihat Detail"
                                            class="text-gray-400 hover:text-primary transition p-2 rounded bg-white shadow-sm border border-gray-100">
                                        <i class="ph ph-eye text-lg"></i>
                                    </button>
                                    
                                    <button onclick="konfirmasiHapus({{ $trx->id }}, '{{ $trx->nomor_nota }}')" title="Hapus Riwayat"
                                            class="text-red-400 hover:text-red-600 transition p-2 rounded bg-white shadow-sm border border-gray-100">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                </td>
                                
                                <div id="modal-trx-{{ $trx->id }}" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
                                    <div class="fixed inset-0 bg-dark/40 backdrop-blur-sm transition-opacity" 
                                         onclick="document.getElementById('modal-trx-{{ $trx->id }}').classList.add('hidden')"></div>
                                
                                    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 z-10 shadow-2xl overflow-hidden flex flex-col max-h-[80vh] border border-primary-soft">
                                        
                                        <div class="p-5 border-b border-primary-soft bg-bg flex justify-between items-center">
                                            <div>
                                                <h3 class="text-lg font-bold text-dark">Detail Transaksi #{{ $trx->id }}</h3>
                                                <p class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                            <button onclick="document.getElementById('modal-trx-{{ $trx->id }}').classList.add('hidden')" 
                                                    class="text-gray-400 hover:text-primary transition p-1">
                                                <i class="ph ph-x text-2xl"></i>
                                            </button>
                                        </div>
                                
                                        <div class="p-6 overflow-y-auto flex-1">
                                            <div class="space-y-4">
                                                @forelse($trx->detailTransaksi as $detail)
                                                <div class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                                    <div>
                                                        <p class="font-semibold text-dark">{{ $detail->produk->nama_produk ?? 'Produk Terhapus' }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $detail->jumlah_beli }}x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                    <p class="font-bold text-secondary">
                                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                @empty
                                                <div class="text-center py-4 text-gray-400 italic">
                                                    Belum ada detail produk.
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>
                                
                                        <div class="p-5 border-t border-primary-soft bg-gray-50 flex justify-between items-center">
                                            <span class="font-bold text-gray-600">Total Keseluruhan</span>
                                            <span class="font-bold text-2xl text-primary">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>           
                </div>
            </div>

            {{-- Link Navigasi Pagination --}}
            <div class="mt-4">
                {{ $transaksis->links() }}
            </div>

        </div>
    </main>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
            } else {
                overlay.classList.remove('hidden');
            }
        }

        // ================= FITUR CHECKBOX & DELETE BULK =================
        function toggleSemuaCheckbox(source) {
            const checkboxes = document.querySelectorAll('.checkbox-riwayat');
            checkboxes.forEach(cb => cb.checked = source.checked);
            periksaCheckbox();
        }

        function periksaCheckbox() {
            const checkboxes = document.querySelectorAll('.checkbox-riwayat:checked');
            const btnHapusBulk = document.getElementById('btn-hapus-terpilih');
            if (checkboxes.length > 0) {
                btnHapusBulk.classList.remove('hidden');
            } else {
                btnHapusBulk.classList.add('hidden');
                document.getElementById('check-all').checked = false;
            }
        }

        function konfirmasiHapusBulk() {
            const checkboxes = document.querySelectorAll('.checkbox-riwayat:checked');
            let ids = [];
            checkboxes.forEach(cb => ids.push(cb.value));

            Swal.fire({
                title: 'Hapus Terpilih?',
                text: `Anda memilih ${ids.length} riwayat. Apakah stok produk ingin dikembalikan?`,
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#2EC4B6',
                denyButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Kembalikan Stok',
                denyButtonText: 'Tidak, Hapus Saja',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed || result.isDenied) {
                    const kembalikan = result.isConfirmed ? 'true' : 'false';
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/riwayat/bulk-delete`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="ids" value="${ids.join(',')}">
                        <input type="hidden" name="restore_stock" value="${kembalikan}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function konfirmasiHapusSemua() {
            Swal.fire({
                title: 'BAHAYA! Hapus SELURUH Riwayat?',
                text: `Semua data dari awal sampai akhir akan hilang. Apakah stok produk ingin dikembalikan?`,
                icon: 'error',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#2EC4B6',
                denyButtonColor: '#ef4444', 
                confirmButtonText: 'Ya, Kembalikan Stok',
                denyButtonText: 'Tidak, Hapus Saja',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed || result.isDenied) {
                    const kembalikan = result.isConfirmed ? 'true' : 'false';
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/riwayat/delete-all`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="restore_stock" value="${kembalikan}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function konfirmasiHapus(id, nota) {
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: `Nota: ${nota}. Apakah stok produk ingin dikembalikan?`,
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#2EC4B6', 
                denyButtonColor: '#9ca3af',   
                confirmButtonText: 'Ya, Kembalikan Stok',
                denyButtonText: 'Tidak, Hapus Saja',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed || result.isDenied) {
                    const kembalikan = result.isConfirmed ? 'true' : 'false';
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/riwayat/${id}`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="restore_stock" value="${kembalikan}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // ================= FITUR CETAK NOTA DARI RIWAYAT =================
        function cetakNotaRiwayat(data) {
            // 1. Hapus iframe lama jika sebelumnya sudah pernah cetak
            let iframeLama = document.getElementById('iframe-nota');
            if (iframeLama) {
                iframeLama.remove();
            }

            // 2. Buat iframe baru secara tersembunyi di latar belakang
            const iframe = document.createElement('iframe');
            iframe.id = 'iframe-nota';
            iframe.style.position = 'fixed';
            iframe.style.right = '0';
            iframe.style.bottom = '0';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = '0';
            document.body.appendChild(iframe);

            // 3. Template HTML Nota (Sama seperti sebelumnya)
            const htmlNota = `
                <html>
                <head>
                <title>Cetak Nota - ${data.nota}</title>
                <style>
                @page { size: 58mm auto; margin: 0; }
                body { font-family: 'Courier New', Courier, monospace; width: 50mm; margin: 0 auto; padding: 5px 0; font-size: 11px; color: black;}
                .text-center { text-align: center; }
                .line { border-bottom: 1px dashed #000; margin: 5px 0; }
                table { width: 100%; border-collapse: collapse; }
                .text-right { text-align: right; }
                </style>
                </head>
                <body> <div class="text-center">
                <strong style="font-size: 16px;">NADYA BAKERY</strong><br>
                Jl. Contoh No. 123, Jakarta<br>
                Telp: 0812-3456-7890
                </div>
                <div class="line"></div>
                <div>
                Nota : ${data.nota}<br>
                Tgl  : ${new Date().toLocaleString('id-ID')}<br>
                Kasir: ${data.kasir}
                </div>
                <div class="line"></div>
                <table>
                ${data.items.map(item => `
                    <tr>
                        <td colspan="2">${item.nama}</td>
                    </tr>
                    <tr>
                        <td>${item.qty} x ${item.harga.toLocaleString('id-ID')}</td>
                        <td class="text-right">${(item.qty * item.harga).toLocaleString('id-ID')}</td>
                    </tr>
                `).join('')}
                </table>
                <div class="line"></div>
                <table>
                <tr style="font-weight:bold; font-size: 13px;">
                    <td>TOTAL</td>
                    <td class="text-right">Rp ${data.total.toLocaleString('id-ID')}</td>
                </tr>
                </table>
                <div class="line"></div>
                <div class="text-center">Terima Kasih Atas Kunjungan Anda!</div>
                </body>
                </html>
            `;

            // 4. Masukkan HTML ke dalam iframe
            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(htmlNota);
            doc.close();

            // 5. Beri jeda 1 detik agar HP selesai merender HTML, lalu cetak
            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 1000); 
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((registration) => {
                    console.log('PWA Service Worker berhasil didaftarkan!', registration.scope);
                }).catch((error) => {
                    console.log('PWA Service Worker gagal didaftarkan:', error);
                });
            });
        }

        @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#be185d' });
        @endif
        @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Ups!', text: "{{ session('error') }}", confirmButtonColor: '#be185d' });
        @endif
    </script>
</body>
</html>