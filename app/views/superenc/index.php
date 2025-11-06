<?php include '../app/views/templates/header.php'; ?>
<div class="p-8">
  <h1 class="text-2xl font-bold mb-6">Super Encryption (Scytale + Salsa20)</h1>

  <form method="POST" action="<?= BASEURL ?>/SuperEnc/encrypt" class="bg-white shadow-lg p-6 rounded-xl mb-8">
    <label class="block text-gray-700 font-medium mb-2">Teks yang akan dienkripsi</label>
    <textarea name="text" class="border rounded w-full p-2 mb-4" rows="4" required><?= $data['text'] ?? '' ?></textarea>

    <label class="block text-gray-700 font-medium mb-2">Kunci Scytale (jumlah baris)</label>
    <input type="number" name="key" class="border rounded w-full p-2 mb-4" min="2" required value="<?= $data['key'] ?? '' ?>">

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Enkripsi</button>
  </form>

  <?php if (isset($data['encrypted'])): ?>
  <div class="bg-gray-100 p-4 rounded-lg">
    <h2 class="text-xl font-semibold mb-2">Hasil Super Encryption:</h2>
    <p class="break-all text-sm bg-white p-2 rounded"><?= htmlspecialchars($data['encrypted']) ?></p>
  </div>
  <?php endif; ?>
</div>
<?php include '../app/views/templates/footer.php'; ?>
