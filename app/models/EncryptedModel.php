<?php
class EncryptedModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // gunakan koneksi PDO
    }

    public function saveEncryptedData($feature_name, $user_id, $plaintext) {
        $cipher = ChaChaHelper::encrypt($plaintext);
        $stmt = $this->db->prepare("INSERT INTO encrypted_data (user_id, feature_name, plaintext, encrypted_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $feature_name, $plaintext, $cipher]);
    }

    public function getDecryptedDataByUser($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM encrypted_data WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $records = $stmt->fetchAll();

        foreach ($records as &$row) {
            $row['decrypted'] = ChaChaHelper::decrypt($row['encrypted_text']);
        }
        return $records;
    }

    public function saveDemoPassword($original, $scrypt, $chacha) {
        $stmt = $this->db->prepare("INSERT INTO demo_passwords (original, scrypt_hash, chacha_encrypted) VALUES (?, ?, ?)");
        $stmt->execute([$original, $scrypt, $chacha]);
    }

    public function saveDemoText($original, $super, $chacha) {
        $stmt = $this->db->prepare("INSERT INTO demo_texts (original, super_encrypted, chacha_encrypted) VALUES (?, ?, ?)");
        $stmt->execute([$original, $super, $chacha]);
    }

    public function getDemoPasswords() {
        $stmt = $this->db->query("SELECT * FROM demo_passwords ORDER BY created_at DESC");
        return $stmt->fetchAll(); // ✅ harus array
    }

    public function getDemoTexts() {
        $stmt = $this->db->query("SELECT * FROM demo_texts ORDER BY created_at DESC");
        return $stmt->fetchAll(); // ✅ harus array
    }
}
