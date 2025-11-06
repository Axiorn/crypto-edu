<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
</head>
<body>
    <div class="max-w-lg mx-auto mt-10 text-center">
  <h2 class="text-xl font-semibold mb-3">Proses Selesai!</h2>
  <p>Nama File Hasil: <strong><?= htmlspecialchars($result) ?></strong></p>
  <a href="public/encrypted/<?= htmlspecialchars($result) ?>" class="text-blue-500 underline">Unduh File</a>
</div>

</body>
</html>