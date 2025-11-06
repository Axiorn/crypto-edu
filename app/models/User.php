<?php
require_once __DIR__ . '/../../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($username, $password) {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) throw new Exception('Username sudah ada.');

        $hash = sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );

        $stmt = $this->db->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
        $stmt->execute([$username, $hash]);
        return $this->db->lastInsertId();
    }

    public function register($username, $password) {
        return $this->create($username, $password);
    }

    public function login($username, $password) {
        $user = $this->getByUsername($username);
        if ($user && sodium_crypto_pwhash_str_verify($user['password_hash'], $password)) {
            return $user;
        }
        return false;
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
