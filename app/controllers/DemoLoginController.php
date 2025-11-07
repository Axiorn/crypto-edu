<?php
class DemoLoginController {
    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            session_start();

            if ($action === 'encrypt') {
                $password = $_POST['password'] ?? '';
                if (empty($password)) {
                    echo json_encode(['error' => 'Password tidak boleh kosong']);
                    return;
                }

                $hash = sodium_crypto_pwhash_str(
                    $password,
                    SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
                    SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
                );

                $_SESSION['demo_scrypt_hash'] = $hash;
                echo json_encode(['hash' => $hash]);
                return;
            }

            if ($action === 'verify') {
                $verify = $_POST['verify'] ?? '';
                $storedHash = $_SESSION['demo_scrypt_hash'] ?? '';

                if (empty($storedHash)) {
                    echo json_encode(['error' => 'Hash belum tersedia. Silakan enkripsi dulu.']);
                    return;
                }

                $result = sodium_crypto_pwhash_str_verify($storedHash, $verify);
                echo json_encode(['verified' => $result]);
                return;
            }

            echo json_encode(['error' => 'Aksi tidak dikenali']);
        }
    }
}
