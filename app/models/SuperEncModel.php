<?php
require_once '../app/helpers/ScytaleCipher.php';
require_once '../app/helpers/Salsa20Helper.php';
require_once '../app/models/EncryptedModel.php';

class SuperEncModel extends EncryptedModel {
    public function superEncrypt($text, $scytaleKey, $user_id) {
        // Langkah 1: Enkripsi dengan Scytale
        $scytaleEncrypted = ScytaleCipher::encrypt($text, $scytaleKey);

        // Langkah 2: Enkripsi hasilnya dengan Salsa20
        $salsaEncrypted = Salsa20Helper::encrypt($scytaleEncrypted);

        // Simpan ke database dengan ChaCha20 (via EncryptedModel)
        $this->saveEncryptedData("Super Encryption", $user_id, $salsaEncrypted);

        return $salsaEncrypted;
    }

    public function superDecrypt($salsaEncrypted, $scytaleKey) {
        // Langkah 1: Dekripsi Salsa20
        $salsaDecrypted = Salsa20Helper::decrypt($salsaEncrypted);

        // Langkah 2: Dekripsi Scytale
        return ScytaleCipher::decrypt($salsaDecrypted, $scytaleKey);
    }
}
