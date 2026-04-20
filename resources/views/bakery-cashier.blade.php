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
                        <div data-kategori="{{ $produk->kategori_id }}" onclick="tambahKeKeranjang({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, '{{ asset('storage/' . $produk->gambar) }}')" 
                            class="product-card relative bg-white p-3 rounded-2xl shadow-sm hover:shadow-md cursor-pointer transition border border-transparent hover:border-pink-200 group flex flex-col h-full"> <span id="badge-produk-{{ $produk->id }}" class="absolute -top-2 -right-2 z-20 bg-primary text-white text-xs font-bold w-7 h-7 flex items-center justify-center rounded-full shadow-lg border-2 border-white hidden">
                                0
                            </span>
                
                            <div class="w-full aspect-square rounded-xl overflow-hidden mb-3 relative shrink-0">
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
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
                <div class="flex items-center space-x-3">
                    <h2 class="text-lg font-bold text-gray-800">Pesanan Baru</h2>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-3">
                        <span class="bg-pink-100 text-primary text-xs font-bold px-2 py-1 rounded">Status: Aktif</span>
                    </div>
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
                    <button id="btn-kosongkan-keranjang" onclick="hapusKeranjang()" class="hidden w-full mb-4 py-2 border border-red-200 text-red-500 bg-white hover:bg-red-50 rounded-lg text-sm font-bold items-center justify-center transition shadow-sm">
                        <i class="ph ph-trash text-lg mr-2"></i>
                        Kosongkan Keranjang
                    </button>
                    <div class="flex justify-between text-lg font-bold text-gray-800 mt-2">
                        <span>Total Pembayaran</span>
                        <span id="text-total">Rp 0</span>
                    </div>
                </div>
            
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <button id="btn-tunai" onclick="pilihMetode('tunai')" class="py-2 border border-pink-300 bg-pink-50 text-primary rounded-lg text-sm font-bold transition">Tunai</button>
                    <button id="btn-qris" onclick="pilihMetode('qris')" class="py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-lg text-sm font-bold transition">QRIS</button>
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
        let keranjang = [];
        let metodePembayaran = 'tunai';

        function toggleCart() {
            const cartPanel = document.getElementById('cart-panel');
            cartPanel.classList.toggle('translate-x-full');
        }

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

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        function pilihMetode(metode) {
            metodePembayaran = metode;
            const btnTunai = document.getElementById('btn-tunai');
            const btnQris = document.getElementById('btn-qris');

            if (metode === 'tunai') {
                btnTunai.className = "py-2 border border-pink-300 bg-pink-50 text-primary rounded-lg text-sm font-bold transition";
                btnQris.className = "py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-lg text-sm font-bold transition";
            } else {
                btnQris.className = "py-2 border border-pink-300 bg-pink-50 text-primary rounded-lg text-sm font-bold transition";
                btnTunai.className = "py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-lg text-sm font-bold transition";
            }
        }
    
        function tambahKeKeranjang(id, nama, harga, gambar) {
            let itemSudahAda = keranjang.find(item => item.id === id);
    
            if (itemSudahAda) {
                itemSudahAda.qty += 1;
            } else {
                keranjang.push({
                    id: id,
                    nama: nama,
                    harga: harga,
                    gambar: gambar,
                    qty: 1
                });
            }
            renderKeranjang();
        }
    
        function ubahQty(id, jumlah) {
            let item = keranjang.find(item => item.id === id);
            if (item) {
                item.qty += jumlah;
                if (item.qty <= 0) {
                    keranjang = keranjang.filter(item => item.id !== id);
                }
                renderKeranjang();
            }
        }
    
        function renderKeranjang() {
            const listKeranjang = document.getElementById('list-keranjang');
            const btnKosongkan = document.getElementById('btn-kosongkan-keranjang'); // Ambil elemen tombol
            let htmlContent = '';
            let subtotal = 0;
            
            document.querySelectorAll('[id^="badge-produk-"]').forEach(badge => {
                badge.classList.add('hidden');
                badge.innerText = '0';
            });

            // JIKA KERANJANG KOSONG
            if (keranjang.length === 0) {
                listKeranjang.innerHTML = `<div class="text-center text-gray-400 mt-10 text-sm">Belum ada produk dipilih.</div>`;
                updateTotal(0);
                
                const cartBadge = document.getElementById('mobile-cart-badge');
                if(cartBadge) cartBadge.classList.add('hidden');
                
                // Sembunyikan tombol kosongkan keranjang
                if(btnKosongkan) btnKosongkan.classList.add('hidden'); 
                
                return;
            }

            // JIKA KERANJANG ADA ISINYA
            // Tampilkan tombol kosongkan keranjang
            if(btnKosongkan) btnKosongkan.classList.remove('hidden'); 

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
                    badgeProduk.innerText = item.qty; 
                    badgeProduk.classList.remove('hidden'); 
                }
            });

            listKeranjang.innerHTML = htmlContent;
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
    
        function updateTotal(subtotal) {
            let total = subtotal; 
            
            document.getElementById('text-total').innerText = formatRupiah(total);
            document.getElementById('btn-text-total').innerText = formatRupiah(total);
        }

        // Fungsi utama untuk memproses pembayaran
        async function prosesBayar() {
            if (keranjang.length === 0) {
                Swal.fire({
                    title: 'Keranjang Kosong!',
                    text: 'Silakan pilih produk terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonColor: '#2EC4B6',
                    confirmButtonText: 'Oke'
                });
                return;
            }

            // Memunculkan QRIS jika metode yang dipilih adalah QRIS
            if (metodePembayaran === 'qris') {
                const resultQris = await Swal.fire({
                    title: 'Scan QRIS',
                    html: `
                        <p class="text-sm text-gray-500 mb-4">Minta pelanggan scan kode di bawah ini.</p>
                        <img src="{{ asset('storage/images/qris.png') }}?v={{ time() }}" alt="QRIS Toko" class="w-64 h-64 mx-auto object-cover rounded-xl border-2 border-gray-100 shadow-sm">
                        <p class="font-bold text-xl mt-4 text-primary">${document.getElementById('text-total').innerText}</p>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#2EC4B6',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Sudah Dibayar',
                    cancelButtonText: 'Batal'
                });

                if (!resultQris.isConfirmed) {
                    return;
                }
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
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
                    body: JSON.stringify({ 
                        keranjang: keranjang,
                        metode_pembayaran: metodePembayaran 
                    }) 
                });

                const result = await response.json();

                if (result.success) {
                Swal.fire({
                    title: 'Yeay, Berhasil! 🎉',
                    html: `Pembayaran sukses.<br><b>Nomor Nota:</b> ${result.nota}`,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Cetak Nota',
                    cancelButtonText: 'Selesai',
                    confirmButtonColor: '#be185d',
                }).then((swalResult) => {
                    if (swalResult.isConfirmed) {
                        // Panggil fungsi cetak dengan data yang ada di keranjang
                        cetakNota({
                            nota: result.nota,
                            kasir: 'Kasir Nadya',
                            items: keranjang,
                            total: keranjang.reduce((acc, item) => acc + (item.harga * item.qty), 0),
                            pajak: keranjang.reduce((acc, item) => acc + (item.harga * item.qty), 0) * 0.1,
                            grandTotal: keranjang.reduce((acc, item) => acc + (item.harga * item.qty), 0) * 1.1
                        });
                    }
                    keranjang = [];
                    renderKeranjang();
                });
            }

            } catch (error) {
                console.error(error);
                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: 'Gangguan jaringan saat menghubungi server.',
                    icon: 'error',
                    confirmButtonColor: '#2EC4B6'
                });
            }
        }
        // Akhir dari fungsi prosesBayar()

    
        function filterKategori(kategoriId) {
            const allBtns = document.querySelectorAll('.kategori-btn');
            
            allBtns.forEach(btn => {
                btn.className = "kategori-btn bg-white text-gray-500 hover:text-primary border border-gray-200 px-5 py-2 rounded-full text-sm font-medium shrink-0 transition-colors duration-200";
            });

            let activeBtn;
            if (kategoriId === 'all') {
                activeBtn = document.getElementById('btn-kategori-all');
            } else {
                activeBtn = document.getElementById(`btn-kategori-${kategoriId}`);
            }
            
            if (activeBtn) {
                activeBtn.className = "kategori-btn bg-primary text-white px-5 py-2 rounded-full text-sm font-medium shadow-md shrink-0 transition-colors duration-200";
            }

            const allProducts = document.querySelectorAll('.product-card');
            
            allProducts.forEach(card => {
                const cardKategori = card.getAttribute('data-kategori');
                
                if (kategoriId === 'all' || cardKategori == kategoriId) {
                    card.style.display = 'block'; 
                } else {
                    card.style.display = 'none'; 
                }
            });
        }

        function cariProduk() {
            const keyword = document.getElementById('input-pencarian').value.toLowerCase();
            const allProducts = document.querySelectorAll('.product-card');

            allProducts.forEach(card => {
                const namaProduk = card.querySelector('h3').innerText.toLowerCase();

                if (namaProduk.includes(keyword)) {
                    card.style.display = 'block'; 
                } else {
                    card.style.display = 'none';  
                }
            });
        }

        function updateJam() {
            const elemenTanggal = document.getElementById('tanggal-hari-ini');
            const sekarang = new Date();
    
            const opsiTanggal = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formatTanggal = sekarang.toLocaleDateString('id-ID', opsiTanggal);
    
            // Menambahkan format jam:menit:detik
            const formatJam = sekarang.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
    
            if (elemenTanggal) {
                elemenTanggal.innerText = `${formatTanggal} | ${formatJam}`;
            }
        }

        // Jalankan setiap 1 detik agar jam terus berdetak
        setInterval(updateJam, 1000);

        function cetakNota(data) {
            const printWindow = window.open('', '_blank', 'width=300,height=600');
    
            // Template HTML untuk nota thermal
            const htmlNota = `
                <html>
                <head>
                <title>Cetak Nota - ${data.nota}</title>
                <style>
                @page { size: 58mm auto; margin: 0; }
                body { font-family: 'Courier New', Courier, monospace; width: 58mm; padding: 5px; font-size: 12px; }
                .text-center { text-align: center; }
                .line { border-bottom: 1px dashed #000; margin: 5px 0; }
                table { width: 100%; border-collapse: collapse; }
                .text-right { text-align: right; }
                </style>
                </head>
                <body onload="window.print(); window.close();">
                <div class="text-center">
                <strong>NADYA BAKERY</strong><br>
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
                        <td>${item.qty} x ${item.harga.toLocaleString()}</td>
                        <td class="text-right">${(item.qty * item.harga).toLocaleString()}</td>
                    </tr>
                `).join('')}
                </table>
                <div class="line"></div>
                <table>
                <tr><td>Total</td><td class="text-right">${data.total.toLocaleString()}</td></tr>
                <tr><td>Pajak (10%)</td><td class="text-right">${data.pajak.toLocaleString()}</td></tr>
                <tr style="font-weight:bold;"><td>GRAND TOTAL</td><td class="text-right">${data.grandTotal.toLocaleString()}</td></tr>
                </table>
                <div class="line"></div>
                <div class="text-center">Terima Kasih Atas Kunjungan Anda!</div>
                </body>
                </html>
            `;

            printWindow.document.write(htmlNota);
            printWindow.document.close();
        }
        
        // Fungsi untuk mengosongkan seluruh isi keranjang
        function hapusKeranjang() {
            // Jika keranjang sudah kosong, tidak perlu melakukan apa-apa
            if (keranjang.length === 0) {
                Swal.fire({
                    title: 'Keranjang Kosong',
                    text: 'Belum ada produk di dalam keranjang.',
                    icon: 'info',
                    confirmButtonColor: '#2EC4B6'
                });
                return;
            }

            // Tampilkan pop-up konfirmasi
            Swal.fire({
                title: 'Kosongkan Keranjang?',
                text: "Semua produk yang telah dipilih akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna merah untuk tombol hapus
                cancelButtonColor: '#9ca3af', // Warna abu-abu untuk tombol batal
                confirmButtonText: 'Ya, Kosongkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kosongkan array keranjang
                    keranjang = [];
                    
                    // Render ulang tampilan keranjang dan angka di badge
                    renderKeranjang();
                    
                    // Notifikasi sukses (opsional, akan hilang sendiri dalam 1.5 detik)
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Keranjang telah dikosongkan.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
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
    </script>
</body>
</html>