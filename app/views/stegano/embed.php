<?php include '../app/views/templates/header.php'; ?>
<div class="p-8 max-w-2xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Embed (PVD Steganography)</h1>
  <?php if (isset($data['error'])): ?><div class="text-red-500 mb-3"><?= htmlspecialchars($data['error']) ?></div><?php endif; ?>
  <form method="POST" action="<?= BASEURL ?>/Stegano/embed" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
    <label>Cover Image (PNG)</label>
    <input type="file" name="cover_image" accept="image/png" class="mb-3" required>

    <label>Payload File (optional) — lebih aman jika sudah terenkripsi</label>
    <input type="file" name="payload_file" class="mb-3">

    <label>OR Message (plain text)</label>
    <textarea name="payload_text" rows="4" class="mb-3 w-full border p-2"></textarea>

    <label>Stego Key (secret)</label>
    <input type="password" name="stego_key" required class="mb-3 w-full border p-2">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Embed</button>
  </form>
</div>
<?php include '../app/views/templates/footer.php'; ?>
