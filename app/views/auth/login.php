<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Login</h2>

    <?php if (!empty($data['success'])): ?>
        <div class="text-green-600 mb-3"><?= htmlspecialchars($data['success']) ?></div>
    <?php endif; ?>

    <?php if (!empty($data['error'])): ?>
        <div class="text-red-500 mb-3"><?= htmlspecialchars($data['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= BASEURL ?>/Auth/login">
        <input type="text" name="username" placeholder="Username" class="w-full p-2 border mb-3" required>
        <input type="password" name="password" placeholder="Password" class="w-full p-2 border mb-3" required>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
    </form>

    <p class="mt-3 text-sm">Belum punya akun?
        <a href="<?= BASEURL ?>/Auth/register" class="text-blue-600">Daftar</a>
    </p>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
