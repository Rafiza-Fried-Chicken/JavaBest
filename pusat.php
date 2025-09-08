<?php
// Contoh API pusat yang menerima URL API panel dan mengembalikan jumlah ress
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $api_url = $_POST['api_url'] ?? '';

    if (filter_var($api_url, FILTER_VALIDATE_URL)) {
        // Logika validasi dan penambahan ress bisa ditambahkan di sini
        // Contoh: selalu berhasil dan memberikan 100 ress
        echo json_encode(['status' => 'success', 'ress' => 100]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'URL API tidak valid']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode harus POST']);
}
