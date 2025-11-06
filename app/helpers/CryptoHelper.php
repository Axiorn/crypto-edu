<?php
class CryptoHelper {

    // kunci rahasia (gunakan environment variable atau file .env untuk keamanan produksi)
    private static $key = 'ini_kunci_rahasia_32_byte_aman_123456'; // 32 byte untuk ChaCha20

    public static function encrypt($plaintext) {
        $nonce = random_bytes(SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES); // 12 byte
        $ciphertext = sodium_crypto_stream_xchacha20_xor($plaintext, $nonce, self::$key);
        // Simpan nonce + ciphertext dalam base64 agar mudah disimpan ke DB
        return base64_encode($nonce . $ciphertext);
    }

    public static function decrypt($data) {
        $decoded = base64_decode($data);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES, null, '8bit');
        $plaintext = sodium_crypto_stream_xchacha20_xor($ciphertext, $nonce, self::$key);
        return $plaintext;
    }
}