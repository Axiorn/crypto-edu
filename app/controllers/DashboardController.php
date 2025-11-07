<?php

class DashboardController
{
    public function index()
    {
        require_once '../app/Views/dashboard/index.php';
    }

    // ✅ Controller untuk load konten demo (dipanggil via fetch)
    public function demo($type = null)
    {
        if (!$type) {
            echo "Tipe demo tidak ditemukan.";
            return;
        }

        // Normalisasi nama file agar sesuai dengan struktur folder kamu
        $filePath = "../app/Views/demo/{$type}_demo.php";

        if (file_exists($filePath)) {
            require $filePath;
        } else {
            echo "<p>⚠️ Halaman demo tidak ditemukan untuk tipe: " . htmlspecialchars($type) . "</p>";
        }
    }
}
