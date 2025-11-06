<?php include '../app/views/templates/header.php'; ?>
<div class="p-8 max-w-2xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Extract Result</h1>
  <p>Payload saved to: <a href="<?= BASEURL . '/' . $data['out'] ?>" class="text-blue-600 underline"><?= htmlspecialchars($data['out']) ?></a></p>
  <p>Length: <?= htmlspecialchars($data['len']) ?> bytes</p>
  <p>Note: Jika payload adalah file terenkripsi (.fenc), gunakan fitur Decrypt File untuk mengembalikan isi asli.</p>
</div>
<?php include '../app/views/templates/footer.php'; ?>
