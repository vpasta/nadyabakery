<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Nadya Bakery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 text-dark h-screen w-full flex overflow-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>
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
                <a href="/riwayat" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
                </a>
                <a href="/pengaturan" class="flex items-center p-3 text-white bg-primary rounded-xl shadow-lg' : 'text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl' }} transition">
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

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="md:hidden flex items-center justify-between bg-white p-4 shadow-sm border-b border-primary-soft">
            <span class="font-bold text-primary text-lg">Pengaturan</span>
            <button onclick="toggleSidebar()" class="text-gray-400"><i class="ph ph-list text-2xl"></i></button>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <h1 class="text-2xl font-bold text-dark mb-6">Pengaturan Sistem</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-primary-soft">
                    <div class="flex items-center space-x-2 mb-6 text-primary">
                        <i class="ph ph-user-circle text-2xl"></i>
                        <h2 class="text-lg font-bold">Keamanan Akun</h2>
                    </div>
                    
                    <form action="{{ url('/pengaturan/profile') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Aktif</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Kosongkan jika tidak ganti)</label>
                            <input type="password" name="password" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition">Simpan Perubahan</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-primary-soft">
                    <div class="flex items-center space-x-2 mb-6 text-primary">
                        <i class="ph ph-qr-code text-2xl"></i>
                        <h2 class="text-lg font-bold">QRIS Pembayaran</h2>
                    </div>

                    <form action="{{ url('/pengaturan/qris') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                        @csrf
                        <div class="relative w-full aspect-square max-w-[250px] border-2 border-gray-300 border-dashed rounded-2xl bg-gray-50 overflow-hidden group mb-4">
                            <input type="file" name="qris_image" id="input-qris" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="previewQris(event)">
                            
                            <img id="preview-qris" src="{{ asset('storage/images/qris.png') }}" class="absolute inset-0 w-full h-full object-cover z-10 {{ file_exists(public_path('storage/images/qris.png')) ? '' : 'hidden' }}">

                            <div id="teks-qris" class="flex flex-col items-center justify-center h-full z-0 {{ file_exists(public_path('storage/images/qris.png')) ? 'hidden' : '' }}">
                                <i class="ph ph-upload-simple text-4xl text-gray-400 mb-2"></i>
                                <span class="text-sm font-semibold text-gray-500 text-center px-4">Klik untuk ganti QRIS</span>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-secondary text-white py-3 rounded-xl font-bold hover:opacity-90 transition">Update Gambar QRIS</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }

        function previewQris(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('preview-qris').src = URL.createObjectURL(file);
                document.getElementById('preview-qris').classList.remove('hidden');
                document.getElementById('teks-qris').classList.add('hidden');
            }
        }

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#be185d' });
        @endif

        @if($errors->any())
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ $errors->first() }}", confirmButtonColor: '#be185d' });
        @endif
    </script>
</body>
</html>