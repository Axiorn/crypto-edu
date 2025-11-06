<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="min-h-screen bg-gray-100 p-8">
  <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4 text-center">CryptoEdu Dashboard</h1>

    <?php if ($data['stage'] === 'menu'): ?>
      <h2 class="text-lg font-semibold mb-3">Pilih Fitur Edukasi:</h2>
      <form method="POST">
        <div class="grid grid-cols-2 gap-4">
          <?php foreach (['login_demo'=>'Login', 'database'=>'Database', 'superenkripsi'=>'Super Enkripsi', 'file'=>'Enkripsi File', 'stegano'=>'Steganografi'] as $key=>$label): ?>
            <button name="section" value="<?= $key ?>" class="bg-blue-600 hover:bg-blue-700 text-white py-3 rounded"><?= $label ?></button>
          <?php endforeach; ?>
        </div>
      </form>

    <?php elseif ($data['stage'] === 'login_demo'): ?>
      <h2 class="font-semibold mb-3">Demo Login (Scrypt Hash)</h2>
      <form method="POST">
        <input type="hidden" name="section" value="login_demo">
        <input type="text" name="username" placeholder="Username" class="border w-full p-2 mb-3" required>
        <input type="password" name="password" placeholder="Password" class="border w-full p-2 mb-3" required>
        <button name="run_login" class="bg-green-600 text-white px-4 py-2 rounded">Run Demo</button>
      </form>

    <?php elseif ($data['stage'] === 'login_result'): ?>
      <h2 class="font-semibold mb-3">Hasil Enkripsi</h2>
      <p><b>Username:</b> <?= $data['username'] ?></p>
      <p><b>Password:</b> <?= $data['password'] ?></p>
      <p><b>Hasil Hash:</b></p>
      <pre class="bg-gray-100 p-2"><?= $data['hash'] ?></pre>
      <form method="POST">
        <input type="hidden" name="section" value="login_demo">
        <button name="explain_login" class="bg-blue-600 text-white px-4 py-2 rounded">Lanjut Penjelasan</button>
      </form>

    <?php elseif ($data['stage'] === 'login_explain'): ?>
      <h2 class="font-semibold mb-3">Penjelasan Algoritma Scrypt</h2>
      <p>Scrypt adalah algoritma derivasi kunci berbasis password yang sangat lambat dan membutuhkan memori tinggi, mencegah serangan brute force.</p>
      <form method="POST"><button name="section" value="menu" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali ke Menu</button></form>

    <?php elseif ($data['stage'] === 'super_demo'): ?>
      <h2 class="font-semibold mb-3">Demo Super Enkripsi (Scytale → Salsa20)</h2>
      <form method="POST">
        <input type="hidden" name="section" value="superenkripsi">
        <textarea name="plaintext" placeholder="Masukkan teks..." class="border w-full p-2 mb-3"></textarea>
        <button name="run_super" class="bg-green-600 text-white px-4 py-2 rounded">Run Demo</button>
      </form>

    <?php elseif ($data['stage'] === 'super_result'): ?>
      <h2 class="font-semibold mb-3">Hasil Enkripsi</h2>
      <p><b>Plaintext:</b> <?= htmlspecialchars($data['plain']) ?></p>
      <p><b>Scytale Cipher:</b> <?= htmlspecialchars($data['scytale']) ?></p>
      <p><b>Salsa20 (simulasi):</b> <?= htmlspecialchars($data['salsa']) ?></p>
      <form method="POST">
        <input type="hidden" name="section" value="superenkripsi">
        <button name="explain_super" class="bg-blue-600 text-white px-4 py-2 rounded">Lanjut Penjelasan</button>
      </form>

    <?php elseif ($data['stage'] === 'super_explain'): ?>
      <h2 class="font-semibold mb-3">Penjelasan Super Enkripsi</h2>
      <p>Super enkripsi menggabungkan dua atau lebih algoritma, misal Scytale (transposisi klasik) dan Salsa20 (stream cipher modern), untuk keamanan berlapis.</p>
      <form method="POST"><button name="section" value="menu" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali ke Menu</button></form>

    <?php elseif ($data['stage'] === 'file_demo'): ?>
      <h2 class="font-semibold mb-3">Demo Enkripsi File</h2>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="section" value="file">
        <input type="file" name="file" class="mb-3">
        <button name="run_file" class="bg-green-600 text-white px-4 py-2 rounded">Run Demo</button>
      </form>

    <?php elseif ($data['stage'] === 'file_result'): ?>
      <h2 class="font-semibold mb-3">Hasil Enkripsi File</h2>
      <p><?= $data['file_demo'] ?></p>
      <form method="POST">
        <input type="hidden" name="section" value="file">
        <button name="explain_file" class="bg-blue-600 text-white px-4 py-2 rounded">Lanjut Penjelasan</button>
      </form>

    <?php elseif ($data['stage'] === 'file_explain'): ?>
      <h2 class="font-semibold mb-3">Penjelasan Enkripsi File</h2>
      <p>File dienkripsi byte demi byte menggunakan algoritma simetris seperti AES/Salsa20 agar tidak terbaca tanpa kunci yang tepat.</p>
      <form method="POST"><button name="section" value="menu" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali ke Menu</button></form>

    <?php elseif ($data['stage'] === 'stegano_demo'): ?>
      <h2 class="font-semibold mb-3">Demo Steganografi</h2>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="section" value="stegano">
        <input type="file" name="image" class="mb-3">
        <input type="text" name="hidden_msg" placeholder="Pesan rahasia" class="border w-full p-2 mb-3">
        <button name="run_stegano" class="bg-green-600 text-white px-4 py-2 rounded">Run Demo</button>
      </form>

    <?php elseif ($data['stage'] === 'stegano_result'): ?>
      <h2 class="font-semibold mb-3">Hasil Steganografi</h2>
      <p><?= htmlspecialchars($data['result']) ?></p>
      <form method="POST">
        <input type="hidden" name="section" value="stegano">
        <button name="explain_stegano" class="bg-blue-600 text-white px-4 py-2 rounded">Lanjut Penjelasan</button>
      </form>

    <?php elseif ($data['stage'] === 'stegano_explain'): ?>
      <h2 class="font-semibold mb-3">Penjelasan Steganografi</h2>
      <p>Steganografi menyembunyikan pesan di dalam media (gambar/suara) tanpa mengubah tampilan luarnya, menggunakan manipulasi bit.</p>
      <form method="POST"><button name="section" value="menu" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali ke Menu</button></form>

    <?php elseif ($data['stage'] === 'database_explain'): ?>
      <h2 class="font-semibold mb-3">Penjelasan Enkripsi Database</h2>
      <p>Data terenkripsi dari fitur lain (file, superenkripsi, dll) kembali dienkripsi menggunakan ChaCha20 sebelum disimpan ke database untuk perlindungan ganda.</p>
      <form method="POST"><button name="section" value="menu" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali ke Menu</button></form>

    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
