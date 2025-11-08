<?php if (session_status() === PHP_SESSION_NONE) 
    session_start(); 
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register | CryptoEdu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0f0e17] flex justify-center items-center min-h-screen">
    <!-- Card Register -->
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center text-gray-800">
        <h2 class="text-2xl font-bold mb-6 text-[#14213D]">Daftar Akun CryptoEdu</h2>

        <?php if (!empty($data['error'])): ?>
            <div class="text-red-500 mb-3 text-sm font-medium">
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASEURL ?>/Auth/register" class="flex flex-col items-center">
            <input 
                type="text" 
                name="username" 
                placeholder="Username" 
                class="w-3/4 p-2 mb-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-[#3da9fc]" 
                required
            >
            <input 
                type="password" 
                name="password" 
                placeholder="Password" 
                class="w-3/4 p-2 mb-5 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-[#3da9fc]" 
                required
            >
            <button 
                type="submit"
                class="w-3/4 bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition duration-200"
            >
                Register
            </button>
        </form>

        <p class="mt-5 text-sm text-gray-700">
            Sudah punya akun?
            <a href="<?= BASEURL ?>/Auth/login" class="text-[#3da9fc] hover:underline font-medium">Login</a>
        </p>
    </div>
</body>
</html>
