<?php
// ===============================
// CONFIG.PHP - Fix Port 3307 & JSON Output
// ===============================

// Paksa header JSON agar JavaScript tidak bingung
header('Content-Type: application/json; charset=utf-8');

// Matikan error tampilan PHP standar
error_reporting(0);
ini_set('display_errors', 0);

$host     = "127.0.0.1"; // Gunakan IP 127.0.0.1 agar port terbaca jelas
$user     = "root";
$password = "";          // Password default XAMPP kosong
$database = "tech_nirvana";
$port     = 3307;        // <--- PENTING: Sesuai screenshot phpMyAdmin Anda

// Koneksi dengan Port spesifik
$conn = @new mysqli($host, $user, $password, $database, $port);

// Cek koneksi
if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Koneksi DB Gagal: ' . $conn->connect_error
    ]);
    exit;
}
?>