<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nadya Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
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
<body class="bg-pastel-bg h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl overflow-hidden border border-pink-100 p-8">
        <div class="text-center mb-8">
            <span class="text-5xl block mb-2">🧁</span>
            <h1 class="text-2xl font-bold text-gray-800">Masuk ke Sistem</h1>
            <p class="text-sm text-gray-500">Khusus Kasir Nadya Bakery</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded-xl text-sm mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="kasir@nadyabakery.com" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
            </div>

            <button type="submit" class="w-full bg-pastel-dark text-white py-3 rounded-xl font-bold hover:bg-pink-700 transition shadow-lg shadow-pink-200 mt-4">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-400 hover:text-pastel-dark transition">← Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>