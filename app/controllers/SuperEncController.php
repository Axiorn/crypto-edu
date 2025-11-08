<?php
require_once '../app/helpers/ScytaleHelper.php';
require_once '../app/helpers/Salsa20Helper.php';
require_once '../app/helpers/CryptoHelper.php';

class SuperEncController {
    public function handle() {
        header('Content-Type: application/json');
        $action = $_POST['action'] ?? null;

        if ($action === 'encrypt') {
            $text = $_POST['text'] ?? '';
            if (!$text) {
                echo json_encode(['error' => 'Teks kosong']);
                return;
            }

            $salsa = Salsa20Helper::encrypt($text);
            echo json_encode(['salsa' => $salsa]);
            return;
        }

        if ($action === 'decrypt') {
            $cipher = $_POST['cipher'] ?? '';
            if (!$cipher) {
                echo json_encode(['error' => 'Cipher kosong']);
                return;
            }

            $plain = Salsa20Helper::decrypt($cipher);
            echo json_encode(['plain' => $plain]);
            return;
        }

        echo json_encode(['error' => 'Aksi tidak dikenali']);
    }
}

