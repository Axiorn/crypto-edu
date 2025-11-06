<?php
class FileModel {

    // Tahap 1: AES 256 CBC
    private function aesEncrypt($data, $password) {
        $key = hash('sha256', $password, true);
        $iv = random_bytes(16);
        $cipher = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $cipher);
    }

    private function aesDecrypt($data, $password) {
        $raw = base64_decode($data);
        $iv = substr($raw, 0, 16);
        $cipher = substr($raw, 16);
        $key = hash('sha256', $password, true);
        return openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }

    // Tahap 2: XOR Keystream
    private function xorEncrypt($data, $password) {
        $keystream = md5($password, true);
        $output = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $output .= $data[$i] ^ $keystream[$i % strlen($keystream)];
        }
        return base64_encode($output);
    }

    private function xorDecrypt($data, $password) {
        $data = base64_decode($data);
        $keystream = md5($password, true);
        $output = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $output .= $data[$i] ^ $keystream[$i % strlen($keystream)];
        }
        return $output;
    }

    // Proses utama
    public function encryptFile($file, $password) {
        $input = file_get_contents($file['tmp_name']);
        $aes = $this->aesEncrypt($input, $password);
        $final = $this->xorEncrypt($aes, $password);

        $encryptedName = 'enc_' . basename($file['name']) . '.fenc';
        file_put_contents('public/encrypted/' . $encryptedName, $final);
        return $encryptedName;
    }

    public function decryptFile($file, $password) {
        $input = file_get_contents($file['tmp_name']);
        $xor = $this->xorDecrypt($input, $password);
        $original = $this->aesDecrypt($xor, $password);

        $decryptedName = 'dec_' . basename($file['name'], '.fenc') . '.pdf';
        file_put_contents('public/uploads/' . $decryptedName, $original);
        return $decryptedName;
    }
}
?>
