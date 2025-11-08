<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($data)) {
    $passwords = $data['passwords'] ?? [];
    $texts = $data['texts'] ?? [];
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
<body class="bg-[#0f0e17] text-[#F8F8F8] min-h-screen">

    <!-- Sticky Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#14213D] shadow-md w-full flex justify-between items-center px-8 py-4">
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

    <!-- Main Content -->
    <div class="pt-[80px] px-6 py-6 max-w-screen-xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-[#FCA311]">Isi Database Demo</h2>

        <!-- Demo Passwords Table -->
        <h3 class="text-lg font-semibold mb-2 text-blue-400">Demo Passwords</h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-[800px] w-full text-sm border border-gray-600">
                <thead class="bg-[#1E1E24] text-[#FCA311]">
                    <tr>
                        <th class="px-2 py-1 border">Original</th>
                        <th class="px-2 py-1 border">Scrypt Hash</th>
                        <th class="px-2 py-1 border">ChaCha20 Encrypted</th>
                        <th class="px-2 py-1 border">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($passwords)): ?>
                        <?php foreach ($passwords as $row): ?>
                            <tr class="border-t border-gray-700">
                                <td class="px-2 py-1"><?= htmlspecialchars($row['original']) ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($row['scrypt_hash']) ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($row['chacha_encrypted']) ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($row['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-2 text-gray-400">Belum ada data password demo.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Demo Texts Table -->
        <h3 class="text-lg font-semibold mb-2 text-green-400">Demo Texts</h3>
        <div class="overflow-x-auto">
            <table class="min-w-[800px] w-full text-sm border border-gray-600">
                <thead class="bg-[#1E1E24] text-[#FCA311]">
                    <tr>
                        <th class="px-2 py-1 border">Original</th>
                        <th class="px-2 py-1 border">Super Encrypted</th>
                        <th class="px-2 py-1 border">ChaCha20 Encrypted</th>
                        <th class="px-2 py-1 border">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($texts)): ?>
                        <?php foreach ($texts as $row): ?>
                            <tr class="border-t border-gray-700">
                                <td class="px-2 py-1"><?= htmlspecialchars($row['original']) ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($row['super_encrypted']) ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($row['chacha_encrypted']) ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($row['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-2 text-gray-400">Belum ada data teks demo.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
