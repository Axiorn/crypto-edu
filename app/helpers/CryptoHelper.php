<?php
class CryptoHelper {
    // kunci rahasia (gunakan environment variable atau file .env untuk keamanan produksi)
    private static $key = null;

private static function getKey() {
    if (self::$key === null) {
        // Gunakan hash SHA256 agar hasilnya pasti 32 byte
        $rawKey = 'ini_kunci_rahasia_32_byte_aman_123456';
        self::$key = hash('sha256', $rawKey, true); // true = output biner
    }
    return self::$key;
}
    // Helper untuk Super Enkripsi
    public static function encrypt($plaintext) {
        $nonce = random_bytes(SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES); // 24 byte
        $ciphertext = sodium_crypto_stream_xchacha20_xor($plaintext, $nonce, self::getKey());
        // Simpan nonce + ciphertext dalam base64 agar mudah disimpan ke DB
        return base64_encode($nonce . $ciphertext);
    }

    public static function decrypt($data) {
        $decoded = base64_decode($data);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES, null, '8bit');
        $plaintext = sodium_crypto_stream_xchacha20_xor($ciphertext, $nonce, self::getKey());

        // Konversi hasil biner ke string UTF-8
        return mb_convert_encoding($plaintext, 'UTF-8', '8bit');
    }

    // Helper untuk file

    public static function encryptFileContent($plaintext) {
        $key = self::getKey();
        $nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES);
        $xorStream = random_bytes(strlen($plaintext));
        $xorred = $plaintext ^ $xorStream;
        $cipher = sodium_crypto_aead_aes256gcm_encrypt($xorred, '', $nonce, $key);

        $lengthBytes = pack('N', strlen($xorStream)); // 4 byte unsigned int
        return base64_encode($lengthBytes . $nonce . $cipher . $xorStream);
    }

    public static function decryptFileContent($encoded) {
        $key = self::getKey();
        $decoded = base64_decode($encoded);

        $lengthBytes = mb_substr($decoded, 0, 4, '8bit');
        $xorLength = unpack('N', $lengthBytes)[1];

        $nonceLen = SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES;
        $nonce = mb_substr($decoded, 4, $nonceLen, '8bit');

        $cipherLen = strlen($decoded) - 4 - $nonceLen - $xorLength;
        $cipher = mb_substr($decoded, 4 + $nonceLen, $cipherLen, '8bit');
        $xorStream = mb_substr($decoded, -$xorLength, null, '8bit');

        $xorred = sodium_crypto_aead_aes256gcm_decrypt($cipher, '', $nonce, $key);
        if ($xorred === false) return null;

        return $xorred ^ $xorStream;
    }




}