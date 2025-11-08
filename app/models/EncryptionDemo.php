<?php
// app/models/EncryptionDemo.php
class EncryptionDemo {
    public function scryptHash($password) {
        return sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
    }

    public function scytaleEncrypt($text) {
        $cols = 3; $out = '';
        for ($i = 0; $i < $cols; $i++)
            for ($j = $i; $j < strlen($text); $j += $cols)
                $out .= $text[$j];
        return $out;
    }

    public function salsaEncrypt($text) {
        return base64_encode(strrev($text)); // simulasi sederhana
    }
}
