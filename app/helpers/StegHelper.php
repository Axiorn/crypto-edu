<?php

class StegHelper {
    public static function embedMessage($imagePath, $message, $outputPath) {
        $img = imagecreatefromstring(file_get_contents($imagePath));
       if (!$img) return false;

        $width = imagesx($img);
        $height = imagesy($img);

       $binary = self::textToBinary($message . '<<END>>');

        $index = 0;
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                if ($index >= strlen($binary)) break 2;

                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // Sisipkan 1 bit ke channel merah
                $r = ($r & 0xFE) | intval($binary[$index]);
                $index++;

                $newColor = imagecolorallocate($img, $r, $g, $b);
                imagesetpixel($img, $x, $y, $newColor);
            }
        }

        // Simpan hasil
        imagepng($img, $outputPath);
        imagedestroy($img);
        return true;
    }
    public static function extractMessage($imagePath) {
        $img = imagecreatefromstring(file_get_contents($imagePath));
        if (!$img) return '';

        $width = imagesx($img);
        $height = imagesy($img);

        $binary = '';
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;

                $bit = $r & 1;
                $binary .= $bit;

                // Cek apakah cukup panjang untuk mengandung <<END>>
                if (strlen($binary) >= 8 * 6) {
                    $text = self::binaryToText($binary);
                    if (str_contains($text, '<<END>>')) {
                        $clean = explode('<<END>>', $text)[0];
                        imagedestroy($img);
                        return $clean;
                    }
                }
            }
        }

        imagedestroy($img);
        return ''; // jika tidak ditemukan
    }


    private static function textToBinary($text) {
        $bin = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $bin .= str_pad(decbin(ord($text[$i])), 8, '0', STR_PAD_LEFT);
        }
        return $bin;
    }

    private static function binaryToText($binary) {
        $text = '';
        for ($i = 0; $i < strlen($binary); $i += 8) {
            $char = substr($binary, $i, 8);
            $text .= chr(bindec($char));
        }
        return $text;
    }

    

}
