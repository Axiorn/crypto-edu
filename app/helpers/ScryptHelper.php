<?php
class ScryptHelper {
    private const OPSLIMIT = SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE;
    private const MEMLIMIT = SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE;

    private const ALG = SODIUM_CRYPTO_PWHASH_ALG_DEFAULT;

    public static function hash($password) {
        return sodium_crypto_pwhash_str(
            $password,
            self::OPSLIMIT,
            self::MEMLIMIT
        );
    }

    public static function verify($password, $hash) {
        return sodium_crypto_pwhash_str_verify($hash, $password);
    }
}
