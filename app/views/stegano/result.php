<?php include '../app/views/templates/header.php'; ?>
<div class="p-8 max-w-2xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Embed Result</h1>
  <p class="mb-3">Stego File: <a href="<?= BASEURL . '/' . $data['out'] ?>" class="text-blue-600 underline"><?= htmlspecialchars($data['out']) ?></a></p>
  <pre class="bg-gray-100 p-3 rounded"><?= print_r($data['info'], true) ?></pre>
</div>
<?php include '../app/views/templates/footer.php'; ?>
