<?php
require_once '../app/helpers/CryptoHelper.php';

class FileEncController {
    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
            echo json_encode(['error' => 'File tidak ditemukan']);
            return;
        }

        $file = $_FILES['file'];
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $finalName = $filename . '.' . $ext;
        $tmpPath = $file['tmp_name'];

        $content = file_get_contents($tmpPath);
        $encrypted = CryptoHelper::encryptFileContent($content);

        $savePath = __DIR__ . '/../../public/encrypted/' . $finalName;

        file_put_contents($savePath, $encrypted);

        echo json_encode([
            'filename' => $finalName,
            'encoded' => urlencode($finalName)
        ]);
    }

    public function download($filename = null) {
        $decodedName = urldecode($filename);
        $path = __DIR__ . '/../../public/encrypted/' . $decodedName;

        if (!$filename || !file_exists($path)) {
            http_response_code(404);
            echo "File tidak ditemukan.";
            return;
        }

        $ext = pathinfo($decodedName, PATHINFO_EXTENSION); // ✅ pakai decoded
        $mime = match ($ext) {
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'txt' => 'text/plain',
            default => 'application/octet-stream'
        };

        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($decodedName) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    public function decrypt() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
            echo json_encode(['error' => 'File tidak ditemukan']);
            return;
        }

        $file = $_FILES['file'];
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $finalName = $filename . '_decrypted.' . $ext;
        $tmpPath = $file['tmp_name'];

        $content = file_get_contents($tmpPath);
        $decrypted = CryptoHelper::decryptFileContent($content);

        $savePath = __DIR__ . '/../../public/encrypted/' . $finalName;
        file_put_contents($savePath, $decrypted);

        echo json_encode([
            'filename' => $finalName,
            'encoded' => urlencode($finalName)
        ]);
    }


}
