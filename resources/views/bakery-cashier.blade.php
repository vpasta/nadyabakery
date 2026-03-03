<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Nadya Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Scrollbar cantik agar sesuai tema */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #fbcfe8; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #be185d; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-pink': '#ffe4e6',
                        'pastel-dark': '#be185d',
                        'pastel-bg': '#fff1f2',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-700 h-screen overflow-hidden flex">

    <aside class="w-20 md:w-64 bg-white border-r border-pink-100 flex flex-col justify-between hidden md:flex">
        <div>
            <div class="h-20 flex items-center justify-center border-b border-pink-50">
                <span class="text-3xl">🧁</span>
                <span class="ml-2 font-bold text-pastel-dark text-xl hidden md:block">Nadya Bakery</span>
            </div>

            <nav class="p-4 space-y-2">
                <a href="#" class="flex items-center p-3 text-white bg-pastel-dark rounded-xl shadow-lg shadow-pink-200 transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium hidden md:block">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium hidden md:block">Riwayat</span>
                </a>
                <a href="#" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium hidden md:block">Stok Produk</span>
                </a>
                <a href="#" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
                    <i class="ph ph-gear text-2xl"></i>
                    <span class="ml-3 font-medium hidden md:block">Pengaturan</span>
                </a>
            </nav>
        </div>

        <div class="p-4">
            <a href="/logout" class="flex items-center p-3 text-red-400 hover:bg-red-50 rounded-xl transition">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="ml-3 font-medium hidden md:block">Keluar</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex h-full">
        
        <div class="flex-1 flex flex-col h-full bg-gray-50">
            <header class="h-20 bg-white border-b border-gray-100 px-8 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Menu Hari Ini</h1>
                    <p class="text-xs text-gray-400">Selasa, 12 Oktober 2024</p>
                </div>
                <div class="relative">
                    <i class="ph ph-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" placeholder="Cari roti..." class="pl-10 pr-4 py-2 bg-gray-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-300 w-64">
                </div>
            </header>

            <div class="px-8 py-4">
                <div class="flex space-x-3 overflow-x-auto pb-2">
                    <button class="bg-pastel-dark text-white px-5 py-2 rounded-full text-sm font-medium shadow-md">Semua</button>
                    @foreach($kategoris as $kategori)
                        <button class="bg-white text-gray-500 hover:text-pastel-dark border border-gray-200 px-5 py-2 rounded-full text-sm font-medium">
                            {{ $kategori->nama_kategori }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-8 pb-8">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    
                    @foreach($produks as $produk)
                        <div onclick="tambahKeKeranjang({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, '{{ $produk->gambar }}')" 
                            class="bg-white p-4 rounded-2xl shadow-sm hover:shadow-md cursor-pointer transition border border-transparent hover:border-pink-200 group">
        
                        <div class="h-32 w-full rounded-xl overflow-hidden mb-3 relative">
                            <img src="{{ $produk->gambar }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $produk->nama_produk }}</h3>
                        <p class="text-pastel-dark font-bold text-sm mt-1">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        </div>
                    @endforeach
            
                </div>
            </div>
        </div>

        <div class="w-96 bg-white border-l border-gray-200 h-full flex flex-col shadow-2xl z-10">
            <div class="h-20 border-b border-gray-100 flex items-center px-6">
                <h2 class="text-lg font-bold text-gray-800">Pesanan Baru</h2>
                <span class="ml-auto bg-pink-100 text-pastel-dark text-xs font-bold px-2 py-1 rounded">Order #204</span>
            </div>

            <div id="list-keranjang" class="flex-1 overflow-y-auto p-4 space-y-4">
                <div class="text-center text-gray-400 mt-10 text-sm">
                    Belum ada produk dipilih.
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 border-t border-gray-200">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span id="text-subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Pajak (10%)</span>
                        <span id="text-pajak">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-800 mt-2">
                        <span>Total</span>
                        <span id="text-total">Rp 0</span>
                    </div>
                </div>
            
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <button class="py-2 border border-gray-300 rounded-lg text-sm hover:bg-white transition">Tunai</button>
                    <button class="py-2 border border-pink-300 bg-pink-50 text-pastel-dark rounded-lg text-sm font-bold">QRIS</button>
                </div>

                <button onclick="prosesBayar()" class="w-full bg-pastel-dark text-white py-4 rounded-xl font-bold shadow-lg shadow-pink-200 hover:bg-pink-700 transition flex justify-between px-6">
                    <span>Bayar Sekarang</span>
                    <span id="btn-text-total">Rp 0</span>
                </button>
            </div>  
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Ini adalah "kotak penyimpanan" kita (Array)
        let keranjang = [];
    
        // 2. Fungsi untuk memformat angka jadi format Rupiah (contoh: 25000 -> 25.000)
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }
    
        // 3. Fungsi yang dipanggil saat produk diklik
        function tambahKeKeranjang(id, nama, harga, gambar) {
            // Cek apakah produk sudah ada di keranjang sebelumnya
            let itemSudahAda = keranjang.find(item => item.id === id);
    
            if (itemSudahAda) {
                // Jika sudah ada, tambahkan jumlahnya (qty) saja
                itemSudahAda.qty += 1;
            } else {
                // Jika belum ada, masukkan produk baru ke keranjang dengan qty 1
                keranjang.push({
                    id: id,
                    nama: nama,
                    harga: harga,
                    gambar: gambar,
                    qty: 1
                });
            }
    
            // Setelah data keranjang berubah, update tampilan layarnya!
            renderKeranjang();
        }
    
        // 4. Fungsi untuk mengubah jumlah barang di keranjang (+ atau -)
        function ubahQty(id, jumlah) {
            let item = keranjang.find(item => item.id === id);
            if (item) {
                item.qty += jumlah;
                // Jika jumlahnya jadi 0, hapus dari keranjang
                if (item.qty <= 0) {
                    keranjang = keranjang.filter(item => item.id !== id);
                }
                renderKeranjang();
            }
        }
    
        // 5. Fungsi ajaib untuk menggambar ulang isi keranjang ke HTML
        function renderKeranjang() {
            const listKeranjang = document.getElementById('list-keranjang');
            let htmlContent = '';
            let subtotal = 0;
    
            if (keranjang.length === 0) {
                listKeranjang.innerHTML = `<div class="text-center text-gray-400 mt-10 text-sm">Belum ada produk dipilih.</div>`;
                updateTotal(0);
                return;
            }
    
            // Looping isi keranjang untuk membuat HTML-nya
            keranjang.forEach(item => {
                subtotal += (item.harga * item.qty);
                
                htmlContent += `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 w-2/3">
                            <img src="${item.gambar}" class="w-12 h-12 rounded-lg object-cover">
                            <div>
                                <h4 class="font-bold text-sm text-gray-700 leading-tight">${item.nama}</h4>
                                <p class="text-xs text-pastel-dark font-bold">${formatRupiah(item.harga)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="ubahQty(${item.id}, -1)" class="w-6 h-6 rounded bg-gray-100 text-gray-600 hover:bg-pink-100 hover:text-pastel-dark transition font-bold">-</button>
                            <span class="text-sm font-bold w-4 text-center">${item.qty}</span>
                            <button onclick="ubahQty(${item.id}, 1)" class="w-6 h-6 rounded bg-pastel-dark text-white hover:bg-pink-700 transition font-bold">+</button>
                        </div>
                    </div>
                `;
            });
    
            // Tampilkan HTML ke layar
            listKeranjang.innerHTML = htmlContent;
            
            // Hitung dan tampilkan total
            updateTotal(subtotal);
        }
    
        // 6. Fungsi untuk menghitung Pajak dan Total
        function updateTotal(subtotal) {
            let pajak = subtotal * 0.10; // Pajak 10%
            let total = subtotal + pajak;
    
            document.getElementById('text-subtotal').innerText = formatRupiah(subtotal);
            document.getElementById('text-pajak').innerText = formatRupiah(pajak);
            document.getElementById('text-total').innerText = formatRupiah(total);
            document.getElementById('btn-text-total').innerText = formatRupiah(total);
        }

        // Fungsi untuk mengirim data ke server
    async function prosesBayar() {
        if (keranjang.length === 0) {
            // Mengganti alert browser dengan SweetAlert Peringatan
            Swal.fire({
                title: 'Keranjang Kosong!',
                text: 'Silakan pilih produk terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#be185d', // Warna pastel-dark
                confirmButtonText: 'Oke'
            });
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            // Tampilkan efek loading (opsional tapi keren)
            Swal.fire({
                title: 'Memproses Pembayaran...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const response = await fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify({ keranjang: keranjang }) 
            });

            const result = await response.json();

            if (result.success) {
                // Notifikasi Sukses yang Cantik!
                Swal.fire({
                    title: 'Yeay, Berhasil! 🎉',
                    html: `Pembayaran sukses diproses.<br><br><b>Nomor Nota:</b> ${result.nota}`,
                    icon: 'success',
                    background: '#fff1f2', // Background pink sangat muda
                    color: '#be185d', // Teks warna pink tua
                    confirmButtonColor: '#be185d',
                    confirmButtonText: 'Selesai'
                });
                
                // Kosongkan keranjang
                keranjang = []; 
                if (typeof isKeranjangBuka !== 'undefined') {
                    isKeranjangBuka = false; // Tutup list di mobile
                }
                renderKeranjang(); 

            } else {
                // Notifikasi Gagal
                Swal.fire({
                    title: 'Oops! Gagal',
                    text: result.message,
                    icon: 'error',
                    confirmButtonColor: '#be185d'
                });
            }

        } catch (error) {
            console.error(error);
            Swal.fire({
                title: 'Terjadi Kesalahan',
                text: 'Gangguan jaringan saat menghubungi server.',
                icon: 'error',
                confirmButtonColor: '#be185d'
            });
        }
    }
    </script>
</body>
</html>