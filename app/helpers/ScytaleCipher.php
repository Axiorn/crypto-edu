<?php
class ScytaleCipher {
    // Enkripsi Scytale
    public static function encrypt($plaintext, $key) {
        $plaintext = str_replace(' ', '', $plaintext); // hilangkan spasi
        $columns = ceil(strlen($plaintext) / $key);
        $matrix = [];

        for ($i = 0; $i < $key; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $index = $j * $key + $i;
                $matrix[$i][$j] = $plaintext[$index] ?? '';
            }
        }

        $cipher = '';
        for ($i = 0; $i < $columns; $i++) {
            for ($j = 0; $j < $key; $j++) {
                $cipher .= $matrix[$j][$i] ?? '';
            }
        }

        return $cipher;
    }

    // Dekripsi Scytale
    public static function decrypt($cipher, $key) {
        $columns = ceil(strlen($cipher) / $key);
        $matrix = [];
        $index = 0;

        for ($i = 0; $i < $columns; $i++) {
            for ($j = 0; $j < $key; $j++) {
                $matrix[$j][$i] = $cipher[$index++] ?? '';
            }
        }

        $plaintext = '';
        for ($i = 0; $i < $key; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $plaintext .= $matrix[$i][$j] ?? '';
            }
        }

        return $plaintext;
    }
}
