<?php
// app/models/SteganoModel.php
require_once __DIR__ . '/../helpers/PvdHelper.php';

class SteganoModel {
    // embed payloadBytes into PNG coverPath, output outPath
    // stegoKey: secret string; returns array with status and info
    public function embedPVD($coverPath, $payloadBytes, $outPath, $stegoKey) {
        if (!extension_loaded('gd')) throw new RuntimeException("GD extension required.");
        $img = imagecreatefrompng($coverPath);
        if (!$img) throw new RuntimeException("Cannot open cover PNG.");

        $w = imagesx($img); $h = imagesy($img);
        $totalPixels = $w * $h;
        $capacityPairs = intdiv($totalPixels, 2);

        $payloadWithLen = pack('N', strlen($payloadBytes)) . $payloadBytes;
        $bits = bytes_to_bits($payloadWithLen);
        $totalBits = count($bits);

        $prng = new HmacPRNG($stegoKey);

        $bitPtr = 0;
        $pairsUsed = 0;
        $trials = 0;
        $maxTrials = $capacityPairs * 3; // safety

        while ($bitPtr < $totalBits && $trials < $maxTrials) {
            $trials++;
            $i = $prng->randInt(0, $totalPixels - 2); // ensure partner exists
            $x1 = $i % $w; $y1 = intdiv($i, $w);
            $j = ($i + 1) % $totalPixels;
            $x2 = $j % $w; $y2 = intdiv($j, $w);

            $rgb1 = imagecolorat($img, $x1, $y1);
            $r1 = ($rgb1 >> 16) & 0xFF; $g1 = ($rgb1 >> 8) & 0xFF; $b1 = $rgb1 & 0xFF;
            $rgb2 = imagecolorat($img, $x2, $y2);
            $r2 = ($rgb2 >> 16) & 0xFF; $g2 = ($rgb2 >> 8) & 0xFF; $b2 = $rgb2 & 0xFF;

            $lum1 = intval(0.299*$r1 + 0.587*$g1 + 0.114*$b1);
            $lum2 = intval(0.299*$r2 + 0.587*$g2 + 0.114*$b2);

            $d = abs($lum1 - $lum2);
            list($low, $high, $tbits) = pvd_range_for_diff($d);
            if ($tbits <= 0) continue;

            $bitsNeeded = min($tbits, $totalBits - $bitPtr);
            $m = 0;
            for ($b=0; $b<$bitsNeeded; $b++) { $m = ($m << 1) | $bits[$bitPtr++]; }

            $rangeSize = $high - $low + 1;
            if ($m >= $rangeSize) $m = $m % $rangeSize;
            $embed = pvd_embed_pair($lum1, $lum2, $low, $high, $m);
            if ($embed === false) continue;
            list($new_l1, $new_l2) = $embed;

            $d1 = $new_l1 - $lum1;
            $d2 = $new_l2 - $lum2;
            $b1_new = max(0, min(255, $b1 + $d1));
            $b2_new = max(0, min(255, $b2 + $d2));

            $color1 = imagecolorallocate($img, $r1, $g1, $b1_new);
            $color2 = imagecolorallocate($img, $r2, $g2, $b2_new);

            imagesetpixel($img, $x1, $y1, $color1);
            imagesetpixel($img, $x2, $y2, $color2);

            $pairsUsed++;
        }

        imagepng($img, $outPath);
        imagedestroy($img);

        return [
            'pairs_used' => $pairsUsed,
            'bits_embedded' => $bitPtr,
            'capacity_pairs' => $capacityPairs,
            'total_bits' => $totalBits
        ];
    }

    // extract payload from stego PNG; expectedBytes can be 0 (unknown)
    public function extractPVD($stegoPath, $stegoKey, $expectedBytes = 0) {
        if (!extension_loaded('gd')) throw new RuntimeException("GD extension required.");
        $img = imagecreatefrompng($stegoPath);
        if (!$img) throw new RuntimeException("Cannot open stego PNG.");

        $w = imagesx($img); $h = imagesy($img);
        $totalPixels = $w * $h;
        $capacityPairs = intdiv($totalPixels, 2);

        $prng = new HmacPRNG($stegoKey);
        $extractedBits = [];
        $trials = 0;
        $maxTrials = $capacityPairs * 3;

        while (($expectedBytes == 0 || count($extractedBits) < ($expectedBytes * 8)) && $trials < $maxTrials) {
            $trials++;
            $i = $prng->randInt(0, $totalPixels - 2);
            $x1 = $i % $w; $y1 = intdiv($i, $w);
            $j = ($i + 1) % $totalPixels;
            $x2 = $j % $w; $y2 = intdiv($j, $w);

            $rgb1 = imagecolorat($img, $x1, $y1);
            $r1 = ($rgb1 >> 16) & 0xFF; $g1 = ($rgb1 >> 8) & 0xFF; $b1 = $rgb1 & 0xFF;
            $rgb2 = imagecolorat($img, $x2, $y2);
            $r2 = ($rgb2 >> 16) & 0xFF; $g2 = ($rgb2 >> 8) & 0xFF; $b2 = $rgb2 & 0xFF;

            $lum1 = intval(0.299*$r1 + 0.587*$g1 + 0.114*$b1);
            $lum2 = intval(0.299*$r2 + 0.587*$g2 + 0.114*$b2);

            $d = abs($lum1 - $lum2);
            list($low, $high, $tbits) = pvd_range_for_diff($d);
            if ($tbits <= 0) continue;

            $t = $d;
            $m = $t - $low;
            if ($m < 0) $m = 0;

            for ($b = $tbits - 1; $b >= 0; $b--) {
                $bit = ($m >> $b) & 1;
                $extractedBits[] = $bit;
                if ($expectedBytes > 0 && count($extractedBits) >= ($expectedBytes * 8)) break;
            }
        }

        imagedestroy($img);

        $payloadBytes = bits_to_bytes($extractedBits);

        // first 4 bytes are length header
        if (strlen($payloadBytes) < 4) return ['success'=>false, 'error'=>'payload too small'];
        $len = unpack('N', substr($payloadBytes,0,4))[1];
        $data = substr($payloadBytes, 4, $len);

        return ['success'=>true, 'length'=>$len, 'payload'=>$data, 'extracted_bits'=>count($extractedBits)];
    }
}
