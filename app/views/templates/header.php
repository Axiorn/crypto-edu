<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Crypto Edu</title>
    <!-- quick dev using CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
<nav class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between">
    <a href="<?= BASEURL ?>" class="font-bold">CryptoEdu</a>
        <div>
        <?php if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['user'])): ?>
            <span class="mr-4">Hi, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
            <a href="<?= BASEURL ?>/Auth/logout" class="text-red-500">Logout</a>
            <?php else: ?>
            <a href="<?= BASEURL ?>/Auth/login" class="mr-4">Login</a>
            <a href="<?= BASEURL ?>/Auth/register">Register</a>
        <?php endif; ?>
        </div>
    </div>
</nav>
<main class="container mx-auto mt-6">