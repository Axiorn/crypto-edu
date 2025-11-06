<?php include '../app/views/templates/header.php'; ?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-xl p-8 w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <?php if (isset($data['error'])): ?>
      <p class="text-red-500 text-sm mb-4"><?= $data['error'] ?></p>
    <?php endif; ?>
    <form method="POST" action="<?= BASEURL ?>/Auth/register">
      <input type="text" name="username" placeholder="Username" class="border rounded w-full p-2 mb-4" required>
      <input type="password" name="password" placeholder="Password" class="border rounded w-full p-2 mb-4" required>
      <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Register</button>
    </form>
    <p class="text-sm mt-4 text-center">Sudah punya akun? <a href="<?= BASEURL ?>/Auth/login" class="text-blue-500 hover:underline">Login</a></p>
  </div>
</div>
<?php include '../app/views/templates/footer.php'; ?>
