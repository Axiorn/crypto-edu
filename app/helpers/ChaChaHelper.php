<?php
class ChaChaHelper {
    
    private static $key = 'demo_chacha_key_32bytes_long!!'; // minimal 32 karakter

    public static function encrypt($plaintext) {
        if (!function_exists('random_bytes')) {
            die("random_bytes() tidak tersedia");
        }
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $key = self::getKey();
        $cipher = sodium_crypto_secretbox($plaintext, $nonce, $key);
        return base64_encode($nonce . $cipher);
    }

    public static function decrypt($encoded) {
        $decoded = base64_decode($encoded);
        $nonce = substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $cipher = substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $key = self::getKey();
        $plaintext = sodium_crypto_secretbox_open($cipher, $nonce, $key);
        return $plaintext === false ? null : $plaintext;
    }

    private static function getKey() {
        return hash('sha256', self::$key, true); // hasil 32-byte binary
    }
}
