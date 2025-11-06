<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-xl shadow-md">
  <h2 class="text-2xl font-bold mb-4">Enkripsi / Dekripsi File</h2>
  <form method="POST" action="index.php?controller=file&action=encrypt" enctype="multipart/form-data" class="mb-4">
    <input type="file" name="file" required class="block w-full border p-2 mb-3">
    <input type="password" name="password" placeholder="Masukkan Password" required class="block w-full border p-2 mb-3">
    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enkripsi File</button>
  </form>

  <form method="POST" action="index.php?controller=file&action=decrypt" enctype="multipart/form-data">
    <input type="file" name="file" required class="block w-full border p-2 mb-3">
    <input type="password" name="password" placeholder="Masukkan Password" required class="block w-full border p-2 mb-3">
    <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Dekripsi File</button>
  </form>
</div>

</body>
</html>