<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CryptoEdu Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/scrypt-js@3.0.1/dist/scrypt.min.js"></script>
    <script src="/crypto-edu/public/js/dashboard.js" defer></script>



</head>
<body class="bg-[#0f0e17] text-[#F8F8F8] min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-4 bg-[#14213D] shadow-md">
        <h1 class="text-xl font-semibold tracking-wide">cryptoEdu</h1>
        <div class="flex items-center gap-4 text-[#F8F8F8]">
            <?php if (!empty($_SESSION['user'])): ?>
                <span class="text-sm">
                    Hi, <span class="font-semibold"><?= htmlspecialchars($_SESSION['user']) ?></span>
                </span>
                <a href="<?= BASEURL ?>/Dashboard" class="text-[#FCA311] hover:underline">Dashboard</a>
                <a href="<?= BASEURL ?>/Database" class="text-[#FCA311] hover:underline">Database Demo</a>
                <a href="<?= BASEURL ?>/Auth/logout" class="text-[#FCA311] hover:underline">Logout</a>
            <?php else: ?>
                <a href="<?= BASEURL ?>/Auth/login" class="text-[#FCA311] hover:underline">Login</a>
                <a href="<?= BASEURL ?>/Auth/register" class="text-[#FCA311] hover:underline">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Kontainer utama yang membuat grid center -->
    <main class="flex-1 flex justify-center items-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">

            <!-- Menu Login -->
            <div class="bg-[#2B2D42] text-center rounded-xl shadow-lg w-64 p-6 hover:scale-105 transition">
                <h2 class="text-xl font-semibold mb-3 text-[#FCA311]">Login</h2>
                <p class="text-sm text-[#E5E5E5] mb-4">Pelajari proses autentikasi dengan Scrypt</p>
                <button 
                    class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md font-medium border border-black hover:bg-[#3295e8] transition"
                    data-demo="login">
                    Demo
                </button>
            </div>

            <!-- Menu Database -->
            <div class="bg-[#2B2D42] text-center rounded-xl shadow-lg w-64 p-6 hover:scale-105 transition">
                <h2 class="text-xl font-semibold mb-3 text-[#FCA311]">Database</h2>
                <p class="text-sm text-[#E5E5E5] mb-4">Amankan data dengan enkripsi ChaCha20</p>
                <button 
                    class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md font-medium border border-black hover:bg-[#3295e8] transition"
                    data-demo="database">
                    Demo
                </button>
            </div>

            <!-- Menu Super Enkripsi -->
            <div class="bg-[#2B2D42] text-center rounded-xl shadow-lg w-64 p-6 hover:scale-105 transition">
                <h2 class="text-xl font-semibold mb-3 text-[#FCA311]">Super Enkripsi</h2>
                <p class="text-sm text-[#E5E5E5] mb-4">Gabungkan Scytale dan Salsa20 untuk keamanan ganda</p>
                <button 
                    class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md font-medium border border-black hover:bg-[#3295e8] transition"
                    data-demo="superenkripsi">
                    Demo
                </button>
            </div>

            <!-- Menu File -->
            <div class="bg-[#2B2D42] text-center rounded-xl shadow-lg w-64 p-6 hover:scale-105 transition">
                <h2 class="text-xl font-semibold mb-3 text-[#FCA311]">File</h2>
                <p class="text-sm text-[#E5E5E5] mb-4">Lindungi file dengan enkripsi kuat</p>
                <button 
                    class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md font-medium border border-black hover:bg-[#3295e8] transition"
                    data-demo="file">
                    Demo
                </button>
            </div>

            <!-- Menu Steganografi -->
            <div class="bg-[#2B2D42] text-center rounded-xl shadow-lg w-64 p-6 hover:scale-105 transition">
                <h2 class="text-xl font-semibold mb-3 text-[#FCA311]">Steganografi</h2>
                <p class="text-sm text-[#E5E5E5] mb-4">Sembunyikan pesan di dalam gambar</p>
                <button 
                    class="bg-[#3da9fc] text-[#fffffe] px-4 py-2 rounded-md font-medium border border-black hover:bg-[#3295e8] transition"
                    data-demo="steganografi">
                    Demo
                </button>
            </div>
        </div>
    </main>

    <!-- Tempat munculnya card demo AJAX -->
    <div id="demo-container" class="fixed inset-0 bg-black bg-opacity-70 hidden justify-center items-center p-4 z-50">
        <div id="demo-card" class="bg-[#2B2D42] p-6 rounded-lg shadow-xl w-full max-w-md relative">
            <!-- Konten demo akan dimuat via AJAX -->
        </div>
    </div>

</body>
</html>
