<?php
require_once '../app/helpers/StegHelper.php';

class StegController {
    public function embed() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image']) || !isset($_POST['message'])) {
            echo json_encode(['error' => 'Gambar atau pesan tidak ditemukan']);
            return;
        }

        $file = $_FILES['image'];
        $message = $_POST['message'];
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $tmpPath = $file['tmp_name'];

        $outputName = $filename . '_steg.' . $ext;
        $outputPath = __DIR__ . '/../../public/steg/' . $outputName;

        $success = StegHelper::embedMessage($tmpPath, $message, $outputPath);

        if ($success) {
            echo json_encode([
                'filename' => $outputName,
                'encoded' => urlencode($outputName)
            ]);
        } else {
            echo json_encode(['error' => 'Gagal menyisipkan pesan ke gambar']);
        }
    }

    public function extract() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
            echo json_encode(['error' => 'Gambar tidak ditemukan']);
            return;
        }

        $file = $_FILES['image'];
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $tmpPath = $file['tmp_name'];

        $message = StegHelper::extractMessage($tmpPath);
        if (!$message) {
            echo json_encode(['error' => 'Tidak ditemukan pesan tersembunyi']);
            return;
        }

        // Overlay pesan ke gambar
        $outputName = $filename . '_revealed.' . $ext;
        $outputPath = __DIR__ . '/../../public/steg/' . $outputName;

        $success = self::overlayText($tmpPath, $message, $outputPath);

        if ($success) {
            echo json_encode([
                'filename' => $outputName,
                'encoded' => urlencode($outputName),
                'message' => $message
            ]);
        } else {
            echo json_encode(['error' => 'Gagal menampilkan pesan pada gambar']);
        }
    }

    private static function overlayText($imagePath, $text, $outputPath) {
        $img = imagecreatefromstring(file_get_contents($imagePath));
        if (!$img) return false;

        $width = imagesx($img);
        $height = imagesy($img);

        $fontSize = 5;
        $x = 10;
        $y = $height - 20;

        $white = imagecolorallocate($img, 255, 255, 255);
        imagestring($img, $fontSize, $x, $y, $text, $white);

        imagepng($img, $outputPath);
        imagedestroy($img);
        return true;
    }

    public function download($filename = null) {
    $decoded = urldecode($filename);
    $path = __DIR__ . '/../../public/steg/' . $decoded;

    if (!$filename || !file_exists($path)) {
        http_response_code(404);
        echo "File tidak ditemukan.";
        return;
    }

    $ext = pathinfo($decoded, PATHINFO_EXTENSION);
    $mime = match ($ext) {
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        default => 'application/octet-stream'
    };

    header('Content-Type: ' . $mime);
    header('Content-Disposition: attachment; filename="' . basename($decoded) . '"');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
}

}
