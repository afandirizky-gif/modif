<?php
// config/get_harga.php

// Menggunakan path absolut berdasarkan direktori file ini berada agar anti-salah alamat
include_once dirname(__FILE__) . '/data.php'; 

header('Content-Type: application/json');

$nama = isset($_GET['nama']) ? trim($_GET['nama']) : '';
$harga = 0;

// Lakukan pengecekan apakah variabel $parts benar-benar ada dan berbentuk array
if (isset($parts) && is_array($parts)) {
    foreach ($parts as $p) {
        if (strcasecmp($p['nama'], $nama) === 0) {
            $harga = $p['harga'];
            break;
        }
    }
}

echo json_encode(['harga' => $harga]);
exit;