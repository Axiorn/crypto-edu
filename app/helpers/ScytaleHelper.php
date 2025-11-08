<?php
class ScytaleHelper {
    public static function encrypt($text, $cols = 5) {
        $text = preg_replace('/\s+/', '', $text); // hilangkan spasi
        $rows = ceil(strlen($text) / $cols);
        $matrix = [];

        for ($i = 0; $i < $rows; $i++) {
            $matrix[] = substr($text, $i * $cols, $cols);
        }

        $cipher = '';
        for ($c = 0; $c < $cols; $c++) {
            for ($r = 0; $r < $rows; $r++) {
                if (isset($matrix[$r][$c])) {
                    $cipher .= $matrix[$r][$c];
                }
            }
        }

        return $cipher;
    }

    public static function decrypt($cipher, $cols = 5) {
        $rows = ceil(strlen($cipher) / $cols);
        $matrix = array_fill(0, $rows, str_repeat(' ', $cols));
        $i = 0;

        for ($c = 0; $c < $cols; $c++) {
            for ($r = 0; $r < $rows; $r++) {
                if ($i < strlen($cipher)) {
                    $matrix[$r][$c] = $cipher[$i++];
                }
            }
        }

        $plain = '';
        foreach ($matrix as $row) {
            $plain .= $row;
        }

        return trim($plain);
    }
}
