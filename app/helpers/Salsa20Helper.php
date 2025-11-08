<?php
class Salsa20Helper {
    private static $key = 'salsa_demo_key';

    public static function encrypt($text) {
        $key = self::$key;
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $k = $key[$i % strlen($key)];
            $result .= chr((ord($char) ^ ord($k)) + 3); // XOR + rotasi
        }
        return base64_encode($result);
    }

    public static function decrypt($cipher) {
        $key = self::$key;
        $decoded = base64_decode($cipher);
        $result = '';
        for ($i = 0; $i < strlen($decoded); $i++) {
            $char = $decoded[$i];
            $k = $key[$i % strlen($key)];
            $result .= chr((ord($char) - 3) ^ ord($k)); // rotasi balik + XOR
        }
        return $result;
    }
}
