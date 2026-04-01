<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
        
        <title>Kasir - Nadya Bakery</title>

        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#F58E8B">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
                <a href="#" class="flex items-center p-3 text-white bg-primary rounded-xl shadow-lg shadow-primary-soft transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
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

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <main class="flex-1 flex h-full min-w-0 overflow-hidden w-full">
        
        <div class="flex-1 flex flex-col h-full bg-gray-50 min-w-0 overflow-hidden w-full">
            <header class="py-4 md:h-20 bg-white border-b border-gray-100 px-4 md:px-8 flex flex-col md:flex-row md:items-center justify-between gap-3 shrink-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg md:text-xl font-bold text-gray-800">Menu Hari Ini</h1>
                        <p id="tanggal-hari-ini" class="text-xs text-gray-400">Memuat tanggal...</p>
                    </div>
                    <button onclick="toggleSidebar()" class="md:hidden text-gray-500 bg-gray-100 hover:bg-pink-100 hover:text-primary p-2 rounded-lg transition">
                        <i class="ph ph-list text-xl"></i>
                    </button>
                </div>
                <div class="relative w-full md:w-auto">
                    <i class="ph ph-magnifying-glass absolute left-3 top-2.5 text-gray-400"></i>
                    <input type="text" id="input-pencarian" onkeyup="cariProduk()" placeholder="Cari roti..." class="pl-10 pr-4 py-2 bg-gray-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-300 w-full md:w-64">
                </div>
            </header>

            <div class="px-4 md:px-8 pt-4 pb-2 shrink-0 w-full min-w-0">
                <div class="flex space-x-3 overflow-x-auto pb-4" id="kategori-container">
                    <button id="btn-kategori-all" onclick="filterKategori('all')" class="kategori-btn bg-primary text-white px-5 py-2 rounded-full text-sm font-medium shadow-md shrink-0 transition-colors duration-200">Semua</button>
                    
                    @foreach($kategoris as $kategori)
                        <button id="btn-kategori-{{ $kategori->id }}" onclick="filterKategori({{ $kategori->id }})" class="kategori-btn bg-white text-gray-500 hover:text-primary border border-gray-200 px-5 py-2 rounded-full text-sm font-medium shrink-0 transition-colors duration-200">
                            {{ $kategori->nama_kategori }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-4 md:px-8 pt-2 pb-24 md:pb-8">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4" id="product-list">
    
                    @foreach($produks as $produk)
                        <div data-kategori="{{ $produk->kategori_id }}" onclick="tambahKeKeranjang({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, '{{ $produk->gambar }}')" 
                            class="product-card relative bg-white p-3 rounded-2xl shadow-sm hover:shadow-md cursor-pointer transition border border-transparent hover:border-pink-200 group flex flex-col h-full"> <span id="badge-produk-{{ $produk->id }}" class="absolute -top-2 -right-2 z-20 bg-primary text-white text-xs font-bold w-7 h-7 flex items-center justify-center rounded-full shadow-lg border-2 border-white hidden">
                                0
                            </span>
                
                            <div class="w-full aspect-square rounded-xl overflow-hidden mb-3 relative shrink-0">
                                <img src="{{ $produk->gambar }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-between">
                                <h3 class="font-bold text-gray-800 text-xs md:text-sm leading-tight line-clamp-2">{{ $produk->nama_produk }}</h3>
                                <p class="text-primary font-bold text-xs md:text-sm mt-2"> Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                
                </div>
            </div>
        </div>

        <div id="cart-panel" class="fixed md:static top-0 right-0 h-full w-[90vw] md:w-96 shrink-0 bg-white border-l border-gray-200 flex flex-col shadow-2xl z-50 transform translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="h-20 border-b border-gray-100 flex items-center justify-between px-6">
                <h2 class="text-lg font-bold text-gray-800">Pesanan Baru</h2>
                
                <div class="flex items-center space-x-3">
                    <span class="bg-pink-100 text-primary text-xs font-bold px-2 py-1 rounded">Order #204</span>
                    <button onclick="toggleCart()" class="md:hidden text-gray-400 hover:text-red-500 transition">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="list-keranjang" class="flex-1 overflow-y-auto p-4 space-y-4">
                <div class="text-center text-gray-400 mt-10 text-sm">
                    Belum ada produk dipilih.
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 border-t border-gray-200 shrink-0">
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
                    <button class="py-2 border border-pink-300 bg-pink-50 text-primary rounded-lg text-sm font-bold">QRIS</button>
                </div>

                <button onclick="prosesBayar()" class="w-full bg-primary text-white py-4 rounded-xl font-bold shadow-lg shadow-primary-soft hover:bg-secondary transition flex justify-between px-6">
                    <span>Bayar Sekarang</span>
                    <span id="btn-text-total">Rp 0</span>
                </button>
            </div>  
        </div>

        <button onclick="toggleCart()" class="md:hidden fixed bottom-6 right-6 bg-primary text-white p-4 rounded-full shadow-2xl z-40 flex items-center justify-center hover:scale-105 transition">
            <i class="ph ph-shopping-cart text-3xl"></i>
            <span id="mobile-cart-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full border-2 border-white hidden">0</span>
        </button>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Ini adalah "kotak penyimpanan" kita (Array)
        let keranjang = [];

        // Fungsi untuk membuka/menutup panel keranjang di mode mobile
        function toggleCart() {
        const cartPanel = document.getElementById('cart-panel');

        // Toggle class translate-x-full (menyembunyikan/menampilkan)
        cartPanel.classList.toggle('translate-x-full');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');
            
            // Toggle class -translate-x-full (menggeser ke kiri 100%)
            sidebar.classList.toggle('-translate-x-full');
            
            // Atur visibilitas Overlay gelap
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden'); // Sembunyikan jika sidebar tertutup
            } else {
                overlay.classList.remove('hidden'); // Munculkan jika sidebar terbuka
            }
        }

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
            
            document.querySelectorAll('[id^="badge-produk-"]').forEach(badge => {
                badge.classList.add('hidden');
                badge.innerText = '0';
            });

            if (keranjang.length === 0) {
                listKeranjang.innerHTML = `<div class="text-center text-gray-400 mt-10 text-sm">Belum ada produk dipilih.</div>`;
                updateTotal(0);
                
                // Update Badge Mobile Utama jadi 0 dan sembunyikan
                const cartBadge = document.getElementById('mobile-cart-badge');
                if(cartBadge) cartBadge.classList.add('hidden');
                
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
                                <p class="text-xs text-primary font-bold">${formatRupiah(item.harga)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="ubahQty(${item.id}, -1)" class="w-6 h-6 rounded bg-gray-100 text-gray-600 hover:bg-pink-100 hover:text-primary transition font-bold">-</button>
                            <span class="text-sm font-bold w-4 text-center">${item.qty}</span>
                            <button onclick="ubahQty(${item.id}, 1)" class="w-6 h-6 rounded bg-primary text-white hover:bg-secondary transition font-bold">+</button>
                        </div>
                    </div>
                `;

                let badgeProduk = document.getElementById(`badge-produk-${item.id}`);
                if (badgeProduk) {
                    badgeProduk.innerText = item.qty; // Tulis angka qty
                    badgeProduk.classList.remove('hidden'); // Munculkan badge-nya
                }

            });
    
            // Tampilkan HTML ke layar
            listKeranjang.innerHTML = htmlContent;
            
            // Hitung dan tampilkan total
            updateTotal(subtotal);

            const cartBadge = document.getElementById('mobile-cart-badge');
            let totalItems = keranjang.reduce((total, item) => total + item.qty, 0); 
            
            if (totalItems > 0 && cartBadge) {
                cartBadge.innerText = totalItems;
                cartBadge.classList.remove('hidden'); 
            } else if (cartBadge) {
                cartBadge.classList.add('hidden'); 
            }
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
        // Fungsi untuk memfilter produk berdasarkan kategori
        function filterKategori(kategoriId) {
            // 1. Mengatur warna tombol kategori
            const allBtns = document.querySelectorAll('.kategori-btn');
            
            // Ubah semua tombol kembali ke warna putih (tidak aktif)
            allBtns.forEach(btn => {
                btn.className = "kategori-btn bg-white text-gray-500 hover:text-primary border border-gray-200 px-5 py-2 rounded-full text-sm font-medium shrink-0 transition-colors duration-200";
            });

            // Beri warna pink (aktif) pada tombol yang sedang diklik
            let activeBtn;
            if (kategoriId === 'all') {
                activeBtn = document.getElementById('btn-kategori-all');
            } else {
                activeBtn = document.getElementById(`btn-kategori-${kategoriId}`);
            }
            
            if (activeBtn) {
                activeBtn.className = "kategori-btn bg-primary text-white px-5 py-2 rounded-full text-sm font-medium shadow-md shrink-0 transition-colors duration-200";
            }

            // 2. Memfilter (Menyembunyikan/Menampilkan) Produk
            const allProducts = document.querySelectorAll('.product-card');
            
            allProducts.forEach(card => {
                // Ambil ID kategori dari atribut data-kategori yang kita buat tadi
                const cardKategori = card.getAttribute('data-kategori');
                
                // Jika pilih 'Semua' ATAU ID kategorinya cocok, tampilkan produknya
                if (kategoriId === 'all' || cardKategori == kategoriId) {
                    card.style.display = 'block'; 
                } else {
                    // Jika tidak cocok, sembunyikan
                    card.style.display = 'none'; 
                }
            });
        }

        // Fungsi untuk mencari produk berdasarkan nama (Real-time)
        function cariProduk() {
            // 1. Ambil kata kunci pencarian dan ubah ke huruf kecil
            const keyword = document.getElementById('input-pencarian').value.toLowerCase();
            
            // 2. Ambil semua elemen kartu produk
            const allProducts = document.querySelectorAll('.product-card');

            // 3. Lakukan perulangan untuk mengecek setiap produk
            allProducts.forEach(card => {
                // Ambil teks nama produk yang ada di dalam tag <h3> pada kartu tersebut
                const namaProduk = card.querySelector('h3').innerText.toLowerCase();

                // 4. Cek apakah nama produk mengandung kata kunci pencarian
                if (namaProduk.includes(keyword)) {
                    card.style.display = 'block'; // Tampilkan jika cocok
                } else {
                    card.style.display = 'none';  // Sembunyikan jika tidak cocok
                }
            });
        }

        // Fungsi untuk menampilkan tanggal hari ini secara real-time
        function updateTanggal() {
            const elemenTanggal = document.getElementById('tanggal-hari-ini');
            
            // Mengambil waktu saat ini
            const hariIni = new Date();
            
            // Pengaturan format tanggal (Nama Hari, Tanggal Bulan Tahun)
            const opsiFormat = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            
            // Mengubah ke format bahasa Indonesia ('id-ID')
            const tanggalDiformat = hariIni.toLocaleDateString('id-ID', opsiFormat);
            
            // Menampilkan ke layar
            if (elemenTanggal) {
                elemenTanggal.innerText = tanggalDiformat;
            }
        }

        // Panggil fungsi ini tepat setelah halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            updateTanggal();
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((registration) => {
                    console.log('PWA Service Worker berhasil didaftarkan!', registration.scope);
                }).catch((error) => {
                    console.log('PWA Service Worker gagal didaftarkan:', error);
                });
            });
        }
    </script>
</body>
</html>