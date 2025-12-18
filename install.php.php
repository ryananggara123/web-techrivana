<?php
// install.php - Script untuk memperbaiki Database Otomatis
require_once 'config.php';

echo "<h1>⚙️ PERBAIKAN DATABASE TECH NIRVANA</h1>";

if (!$conn) {
    die("<h2 style='color:red'>❌ Koneksi Gagal! Cek password/nama db di config.php</h2>");
} else {
    echo "<h3 style='color:green'>✅ Koneksi ke database '$database' berhasil.</h3>";
}

// 1. Buat Tabel Users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_users) === TRUE) {
    echo "✅ Tabel 'users' SIAP.<br>";
} else {
    echo "❌ Gagal buat tabel users: " . $conn->error . "<br>";
}

// 2. Buat Tabel Threads
$sql_threads = "CREATE TABLE IF NOT EXISTS threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author VARCHAR(50) NOT NULL,
    title VARCHAR(100) NOT NULL,
    tag VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_threads) === TRUE) {
    echo "✅ Tabel 'threads' SIAP.<br>";
} else {
    echo "❌ Gagal buat tabel threads: " . $conn->error . "<br>";
}

// 3. Buat Tabel Replies
$sql_replies = "CREATE TABLE IF NOT EXISTS replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT NOT NULL,
    author VARCHAR(50) NOT NULL,
    text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (thread_id) REFERENCES threads(id) ON DELETE CASCADE
)";

if ($conn->query($sql_replies) === TRUE) {
    echo "✅ Tabel 'replies' SIAP.<br>";
} else {
    echo "❌ Gagal buat tabel replies: " . $conn->error . "<br>";
}

echo "<hr><h3>🎉 SELESAI! Silakan coba Daftar Akun lagi sekarang.</h3>";
echo "<a href='index.php?page=login'>Klik disini untuk kembali ke Login</a>";
?>