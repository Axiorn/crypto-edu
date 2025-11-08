<?php
require_once 'ScytaleHelper.php';
require_once 'Salsa20Helper.php';

class SuperEncryptHelper {
    public static function encrypt($text) {
        $scytale = ScytaleHelper::encrypt($text);
        $salsa = Salsa20Helper::encrypt($scytale);
        return $salsa;
    }

    public static function decrypt($cipher) {
        $salsa = Salsa20Helper::decrypt($cipher);
        $scytale = ScytaleHelper::decrypt($salsa);
        return $scytale;
    }
}
