<?php
// app/helpers/PvdHelper.php
// Requires GD extension.

class HmacPRNG {
    private $key;
    private $counter = 0;
    private $buf = '';
    private $bufPos = 0;
    public function __construct($key) {
        $this->key = $key;
    }
    private function refill() {
        $this->counter++;
        $this->buf .= hash_hmac('sha256', pack('N', $this->counter), $this->key, true);
    }
    public function getBytes($n) {
        while (($this->bufPos + $n) > strlen($this->buf)) $this->refill();
        $out = substr($this->buf, $this->bufPos, $n);
        $this->bufPos += $n;
        return $out;
    }
    public function randInt($min, $max) {
        $range = $max - $min + 1;
        $val = unpack('N', $this->getBytes(4))[1];
        return $min + ($val % $range);
    }
}

/* helper bit/byte */
function bytes_to_bits($data) {
    $bits = [];
    $len = strlen($data);
    for ($i=0;$i<$len;$i++){
        $byte = ord($data[$i]);
        for ($b=7;$b>=0;$b--) $bits[] = ($byte >> $b) & 1;
    }
    return $bits;
}

function bits_to_bytes($bits) {
    $out = '';
    $byte = 0; $cnt = 0;
    foreach ($bits as $bit) {
        $byte = ($byte << 1) | ($bit & 1);
        $cnt++;
        if ($cnt == 8) { $out .= chr($byte); $byte = 0; $cnt = 0; }
    }
    return $out;
}

/* PVD range (simple) */
function pvd_range_for_diff($d) {
    if ($d <= 7) return [0,7,1];
    if ($d <= 15) return [8,15,2];
    if ($d <= 31) return [16,31,3];
    if ($d <= 63) return [32,63,4];
    if ($d <= 127) return [64,127,5];
    return [128,255,6];
}

function pvd_embed_pair($p, $q, $low, $high, $m) {
    $d = abs($p - $q);
    $t = $low + $m;
    if ($p >= $q) {
        $avg = intval(($p + $q) / 2);
        $p_new = $avg + intval(ceil($t / 2));
        $q_new = $avg - intval(floor($t / 2));
    } else {
        $avg = intval(($p + $q) / 2);
        $q_new = $avg + intval(ceil($t / 2));
        $p_new = $avg - intval(floor($t / 2));
    }
    if ($p_new < 0 || $p_new > 255 || $q_new < 0 || $q_new > 255) {
        if ($p >= $q) {
            $p_new = $p; $q_new = $p - $t;
            if ($q_new < 0) { $q_new = 0; $p_new = $t; }
        } else {
            $q_new = $q; $p_new = $q - $t;
            if ($p_new < 0) { $p_new = 0; $q_new = $t; }
        }
    }
    if ($p_new < 0 || $p_new > 255 || $q_new < 0 || $q_new > 255) return false;
    return [$p_new, $q_new];
}
