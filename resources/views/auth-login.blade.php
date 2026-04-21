<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login - Nadya Bakery</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#F58E8B">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-bg h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl overflow-hidden border border-primary-soft p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-12 h-12 mb-2 block">
            <h1 class="text-2xl font-bold text-gray-800">Masuk ke Sistem</h1>
            <p class="text-sm text-gray-500">Khusus Kasir Nadya Bakery</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded-xl text-sm mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" name="username" id="username" required 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:outline-none transition" 
                       placeholder="Masukkan username Anda">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
            </div>

            <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-lg shadow-primary-soft mt-4">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-400 hover:text-primary transition">← Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Menangkap pesan error dari session 'error'
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#F58E8B'
            });
        @endif

        // Menangkap error validasi (jika input kosong)
        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Input Tidak Valid',
                text: 'Username dan Password wajib diisi!',
                confirmButtonColor: '#F58E8B'
            });
        @endif

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