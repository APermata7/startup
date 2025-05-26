<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black min-h-screen flex flex-col font-sans">

    <!-- Header -->
    <header class="bg-black text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-lg font-bold tracking-wide">Employee Performance System</h1>
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm hover:underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm hover:underline">Login</a>
                @endauth
            </div>
        @endif
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-6 py-12 grid md:grid-cols-2 gap-10 items-center">
        <!-- Image -->
        <div class="flex justify-center">
            <img src="{{ asset('img/system.png') }}" alt="System Illustration" class="w-64 grayscale">
        </div>

        <!-- Text Content -->
        <div>
            <h2 class="text-3xl font-bold mb-4">Selamat Datang di Employee Performance System</h2>
            <p class="text-lg mb-6">Sistem internal untuk mengelola data pegawai dan laporan kinerja.</p>
            <p class="text-gray-600 italic">"Efisien. Transparan. Terstruktur."</p>
        </div>
    </main>

    <!-- Feature Grid -->
    <section class="container mx-auto px-6 pb-12">
        <div class="grid md:grid-cols-3 gap-6 text-center">
            <div class="bg-gray-100 border border-gray-300 rounded-lg shadow p-6">
                <div class="text-4xl mb-2">👤</div>
                <h3 class="text-lg font-semibold mb-2">Manajemen Pegawai</h3>
                <p class="text-sm text-gray-700">Kelola seluruh data pegawai dengan mudah dan rapi.</p>
            </div>

            <div class="bg-gray-100 border border-gray-300 rounded-lg shadow p-6">
                <div class="text-4xl mb-2">📈</div>
                <h3 class="text-lg font-semibold mb-2">Laporan Kinerja</h3>
                <p class="text-sm text-gray-700">Pantau hasil kerja secara mingguan dan bulanan.</p>
            </div>

            <div class="bg-gray-100 border border-gray-300 rounded-lg shadow p-6">
                <div class="text-4xl mb-2">💾</div>
                <h3 class="text-lg font-semibold mb-2">Penyimpanan Aman</h3>
                <p class="text-sm text-gray-700">Data disimpan secara aman dan bisa diakses kapan saja.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white text-center text-sm py-4">
        © 2025 Employee Performance System. Dibuat oleh Tim TI.
    </footer>

</body>
</html>
