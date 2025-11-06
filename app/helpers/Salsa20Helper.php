<?php
class Salsa20Helper {
    private static $key = 'kunci_salsa20_32_byte_aman_1234567890abcd'; // 32 byte key

    public static function encrypt($plaintext) {
        $nonce = random_bytes(SODIUM_CRYPTO_STREAM_NONCEBYTES); // 8 byte nonce
        $ciphertext = sodium_crypto_stream_xor($plaintext, $nonce, self::$key);
        return base64_encode($nonce . $ciphertext);
    }

    public static function decrypt($data) {
        $decoded = base64_decode($data);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_STREAM_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_STREAM_NONCEBYTES, null, '8bit');
        $plaintext = sodium_crypto_stream_xor($ciphertext, $nonce, self::$key);
        return $plaintext;
    }
}
