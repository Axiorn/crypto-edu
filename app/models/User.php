<?php
// app/models/User.php
require_once __DIR__ . '/../../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // === Register User ===
    public function create($username, $password) {
    $stmt = $this->db->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) throw new Exception('Username sudah ada.');

    // Hash password dengan Scrypt
    $hash = sodium_crypto_pwhash_str(
        $password,
        SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
    );

    // Enkripsi hash dengan ChaCha20
    require_once __DIR__ . '/../helpers/CryptoHelper.php';
    $encryptedHash = CryptoHelper::encrypt($hash);

    $stmt = $this->db->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
    $stmt->execute([$username, $encryptedHash]);
    return $this->db->lastInsertId();
}

    // alias untuk create()
    public function register($username, $password) {
        return $this->create($username, $password);
    }

    // === Login User ===
    public function login($username, $password) {
        $user = $this->getByUsername($username);
        if ($user) {
            require_once __DIR__ . '/../helpers/CryptoHelper.php';

            // Dekripsi hash dengan ChaCha20
            $decryptedHash = CryptoHelper::decrypt($user['password_hash']);

            // Verifikasi password dengan hasil hash Scrypt
            if (sodium_crypto_pwhash_str_verify($decryptedHash, $password)) {
                return $user;
            }
        }
        return false;
    }



    public function getByUsername($username) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
