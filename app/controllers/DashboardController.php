<?php

class DashboardController
{
    public function index()
    {
        require_once '../app/Views/dashboard/index.php';
    }

    // ✅ Controller untuk load konten demo (dipanggil via fetch)
    public function demo($type = null) {
    if (!$type) {
        echo "<p>⚠️ Tipe demo tidak ditemukan.</p>";
        return;
    }

    $filePath = "../app/views/demo/{$type}_demo.php";

    if (file_exists($filePath)) {
        ob_start();
        include $filePath;
        $html = ob_get_clean();
        echo $html;
    } else {
        echo "<p>⚠️ Halaman demo tidak ditemukan untuk tipe: " . htmlspecialchars($type) . "</p>";
    }
}
}