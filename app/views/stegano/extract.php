<?php include '../app/views/templates/header.php'; ?>
<div class="p-8 max-w-2xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Extract Payload</h1>
  <?php if (isset($data['error'])): ?><div class="text-red-500 mb-3"><?= htmlspecialchars($data['error']) ?></div><?php endif; ?>
  <form method="POST" action="<?= BASEURL ?>/Stegano/extract" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
    <label>Stego Image (PNG)</label>
    <input type="file" name="stego_image" accept="image/png" class="mb-3" required>
    <label>Stego Key</label>
    <input type="password" name="stego_key" required class="mb-3 w-full border p-2">
    <button class="bg-green-600 text-white px-4 py-2 rounded">Extract</button>
  </form>
</div>
<?php include '../app/views/templates/footer.php'; ?>
