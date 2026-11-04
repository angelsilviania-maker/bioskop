<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bioskop</title>
    <!-- Tailwind CSS CDN buat cepat & rapi -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <!-- FOTO PROFILE -->
        <div class="flex flex-col items-center justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Foto Profile" class="w-24 h-24 rounded-full object-cover shadow-md border-2 border-blue-600 mb-3">
            <h2 class="text-2xl font-bold text-center text-gray-800">Login Bioskop</h2>
            <p class="text-xs text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition mb-4">
                Masuk
            </button>

            <!-- Link Pindah ke Halaman Register -->
            <div class="text-center text-sm text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar di sini</a>
            </div>
        </form>
    </div>
</body>
</html>
