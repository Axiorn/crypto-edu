<?php include '../app/views/templates/header.php'; ?>
<div class="p-8">
  <h1 class="text-2xl font-bold mb-6">Database Encryption (ChaCha20)</h1>

  <form method="POST" action="<?= BASEURL ?>/Database/store" class="mb-6 bg-white shadow-md p-4 rounded-lg">
    <label class="block text-gray-700 font-medium mb-2">Nama Fitur</label>
    <input type="text" name="feature_name" class="border rounded w-full p-2 mb-4" placeholder="Contoh: Super Encryption">

    <label class="block text-gray-700 font-medium mb-2">Data (Plaintext)</label>
    <textarea name="plaintext" class="border rounded w-full p-2 mb-4" placeholder="Masukkan data hasil enkripsi fitur"></textarea>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan ke Database</button>
  </form>

  <h2 class="text-xl font-semibold mb-4">Data Terenkripsi Anda</h2>
  <table class="w-full border-collapse">
    <thead>
      <tr class="bg-gray-200 text-left">
        <th class="p-2 border">Fitur</th>
        <th class="p-2 border">Encrypted</th>
        <th class="p-2 border">Decrypted</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($data['records'] as $record): ?>
      <tr>
        <td class="border p-2"><?= htmlspecialchars($record['feature_name']) ?></td>
        <td class="border p-2 text-xs text-gray-600"><?= substr($record['encrypted_value'], 0, 50) ?>...</td>
        <td class="border p-2"><?= htmlspecialchars($record['decrypted_value']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php include '../app/views/templates/footer.php'; ?>
