<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Mobile - Nadya Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
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
<body class="bg-gray-50 text-gray-700 relative pb-24"> <header class="bg-white sticky top-0 z-10 shadow-sm rounded-b-2xl">
        <div class="px-4 pt-4 pb-2 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-pastel-dark flex items-center gap-2">
                    🧁 Nadya Bakery
                </h1>
            </div>
            <button class="w-10 h-10 bg-pink-50 text-pastel-dark rounded-full flex items-center justify-center">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <div class="px-4 pb-4 mt-2">
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-3 text-gray-400"></i>
                <input type="text" placeholder="Cari roti atau kue..." class="w-full pl-12 pr-4 py-2.5 bg-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">
            </div>
        </div>

        <div class="px-4 pb-3 flex space-x-2 overflow-x-auto">
            <button class="bg-pastel-dark text-white px-5 py-2 rounded-full text-sm font-medium shadow-md">Semua</button>
                @foreach($kategoris as $kategori)
                    <button class="bg-white text-gray-500 hover:text-pastel-dark border border-gray-200 px-5 py-2 rounded-full text-sm font-medium">
                    {{ $kategori->nama_kategori }}
                    </button>
                @endforeach
        </div>
    </header>

    <main class="p-4 mb-24">
        <div class="grid grid-cols-2 gap-4">
            @foreach($produks as $produk)
            <div onclick="tambahKeKeranjang({{ $produk->id }}, '{{ addslashes($produk->nama_produk) }}', {{ $produk->harga }}, '{{ $produk->gambar }}')" 
                class="bg-white p-3 rounded-2xl shadow-sm border border-transparent hover:border-pink-200 active:scale-95 transition cursor-pointer">
                
                <img src="{{ $produk->gambar }}" alt="{{ $produk->nama_produk }}" class="w-full h-24 object-cover rounded-xl mb-2">
                <h3 class="font-bold text-gray-800 text-xs leading-tight line-clamp-2">{{ $produk->nama_produk }}</h3>
                <div class="mt-2 flex justify-between items-center">
                    <p class="text-pastel-dark font-bold text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <button class="w-7 h-7 bg-pink-50 text-pastel-dark rounded-full flex items-center justify-center font-bold text-lg pointer-events-none">+</button>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <div id="keranjang-container" class="fixed bottom-0 left-0 right-0 z-20 p-4 flex flex-col gap-2 transition-transform duration-300 translate-y-full">
    
        <div id="list-keranjang-mobile" class="bg-white rounded-2xl shadow-2xl p-4 max-h-48 overflow-y-auto space-y-3 border border-pink-100 hidden">
            </div>
    
        <div class="bg-pastel-dark text-white p-4 rounded-2xl shadow-[0_8px_30px_rgb(190,24,93,0.4)] flex justify-between items-center z-30">
            <div class="flex items-center gap-3 cursor-pointer" onclick="toggleKeranjang()">
                <div class="relative">
                    <i class="ph ph-shopping-cart text-3xl"></i>
                    <span id="badge-qty" class="absolute -top-1 -right-1 bg-white text-pastel-dark text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow">0</span>
                </div>
                <div>
                    <p class="text-xs text-pink-200">Total Tagihan <i class="ph ph-caret-up text-[10px]"></i></p>
                    <p id="text-total-mobile" class="font-bold text-lg leading-none">Rp 0</p>
                </div>
            </div>
            
            <button onclick="prosesBayar()" class="bg-white text-pastel-dark px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-100 transition shadow">
                Bayar
            </button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let keranjang = [];
        let isKeranjangBuka = true; // Status apakah list pesanan sedang ditarik ke atas
    
        // Format Rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }
    
        // Tambah Produk
        function tambahKeKeranjang(id, nama, harga, gambar) {
            let itemSudahAda = keranjang.find(item => item.id === id);
    
            if (itemSudahAda) {
                itemSudahAda.qty += 1;
            } else {
                keranjang.push({ id, nama, harga, gambar, qty: 1 });
            }
            
            // Pastikan keranjang terbuka saat kasir menambah produk baru
            isKeranjangBuka = true; 
            renderKeranjang();
        }
    
        // Ubah Jumlah Produk (+ dan -)
        function ubahQty(id, jumlah) {
            let item = keranjang.find(item => item.id === id);
            if (item) {
                item.qty += jumlah;
                if (item.qty <= 0) {
                    // Hapus jika qty 0
                    keranjang = keranjang.filter(item => item.id !== id);
                }
                renderKeranjang();
            }
        }
    
        // Fungsi untuk menyembunyikan/menampilkan list putih di atas keranjang
        function toggleKeranjang() {
            if (keranjang.length === 0) return; // Jangan lakukan apa-apa jika kosong
            
            isKeranjangBuka = !isKeranjangBuka;
            const listKeranjang = document.getElementById('list-keranjang-mobile');
            
            if (isKeranjangBuka) {
                listKeranjang.classList.remove('hidden');
            } else {
                listKeranjang.classList.add('hidden');
            }
        }
    
        // Gambar ulang UI keranjang
        function renderKeranjang() {
            const container = document.getElementById('keranjang-container');
            const listKeranjang = document.getElementById('list-keranjang-mobile');
            const badgeQty = document.getElementById('badge-qty');
            const textTotal = document.getElementById('text-total-mobile');
            
            let htmlContent = '';
            let total = 0;
            let totalQty = 0;
    
            // Jika kosong, tenggelamkan/sembunyikan ke bawah layar
            if (keranjang.length === 0) {
                container.classList.add('translate-y-full');
                listKeranjang.classList.add('hidden');
                return;
            }
    
            // Jika ada isi, munculkan dari bawah layar
            container.classList.remove('translate-y-full');
            if (isKeranjangBuka) {
                listKeranjang.classList.remove('hidden');
            }
    
            // Looping data array keranjang
            keranjang.forEach(item => {
                total += (item.harga * item.qty);
                totalQty += item.qty;
                
                // UI untuk list item (dibuat lebih padat untuk layar HP)
                htmlContent += `
                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded-xl">
                        <div class="flex items-center space-x-3 w-2/3">
                            <img src="${item.gambar}" class="w-10 h-10 rounded-lg object-cover">
                            <div>
                                <h4 class="font-bold text-xs text-gray-700 leading-tight line-clamp-1">${item.nama}</h4>
                                <p class="text-[10px] text-pastel-dark font-bold">${formatRupiah(item.harga)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="ubahQty(${item.id}, -1)" class="w-6 h-6 rounded-full bg-white shadow text-gray-600 hover:text-pastel-dark font-bold flex items-center justify-center">-</button>
                            <span class="text-xs font-bold w-4 text-center">${item.qty}</span>
                            <button onclick="ubahQty(${item.id}, 1)" class="w-6 h-6 rounded-full bg-pastel-dark text-white shadow font-bold flex items-center justify-center">+</button>
                        </div>
                    </div>
                `;
            });
    
            // Masukkan HTML ke layar
            listKeranjang.innerHTML = htmlContent;
            badgeQty.innerText = totalQty;
            
            // Total + Pajak 10%
            let pajak = total * 0.10;
            textTotal.innerText = formatRupiah(total + pajak);
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