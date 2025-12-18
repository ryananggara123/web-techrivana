<?php
// =============================================================
// API.PHP - Backend Logic (DATABASE VERSION)
// =============================================================

// 1. Matikan error display agar tidak merusak format JSON
error_reporting(0);
ini_set('display_errors', 0);

// 2. Panggil konfigurasi database
require_once 'config.php';

session_start();
header('Content-Type: application/json; charset=utf-8');

// Cek koneksi database dari config.php
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Koneksi Database Gagal. Cek config.php']);
    exit;
}

// Fungsi Helper: Menghitung "Waktu yang lalu" (contoh: 2 jam lalu)
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'tahun', 'm' => 'bulan', 'w' => 'minggu',
        'd' => 'hari', 'h' => 'jam', 'i' => 'menit', 's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' lalu' : 'baru saja';
}

// =============================================================
// HANDLE REQUEST
// =============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // ---------------------------------------------------------
    // 1. REGISTER (DAFTAR AKUN)
    // ---------------------------------------------------------
    if ($action === 'register') {
        $email    = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm'] ?? '';

        // Validasi Input Kosong
        if (empty($email) || empty($username) || empty($password)) {
            die(json_encode(['status'=>'error', 'message'=>'Semua kolom wajib diisi.']));
        }
        
        // Validasi Password Match
        if ($password !== $confirm) { 
            die(json_encode(['status'=>'error', 'message'=>'Konfirmasi password tidak sama.'])); 
        }

        // Cek Duplikat di Database (Username atau Email sudah ada?)
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) { 
            die(json_encode(['status'=>'error', 'message'=>'Username atau Email sudah terdaftar.'])); 
        }
        $stmt->close();

        // Enkripsi Password & Simpan ke Database
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        
        if ($stmt->execute()) {
            // Auto Login setelah daftar berhasil
            $_SESSION['user'] = htmlspecialchars($username);
            echo json_encode(['status' => 'ok', 'user' => $_SESSION['user']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftar ke database.']);
        }
        exit;
    }

    // ---------------------------------------------------------
    // 2. LOGIN
    // ---------------------------------------------------------
    if ($action === 'login') {
        $identifier = trim($_POST['identifier'] ?? '');
        $password   = $_POST['password'] ?? '';

        // Cari user berdasarkan username ATAU email
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $identifier, $identifier);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $row = $res->fetch_assoc();
            // Verifikasi Password Hash
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = htmlspecialchars($row['username']);
                echo json_encode(['status' => 'ok', 'user' => $_SESSION['user']]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Password salah.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Akun tidak ditemukan.']);
        }
        exit;
    }

    // ---------------------------------------------------------
    // 3. LOGOUT
    // ---------------------------------------------------------
    if ($action === 'logout') {
        unset($_SESSION['user']);
        session_destroy(); 
        echo json_encode(['status' => 'ok']);
        exit;
    }

    // ---------------------------------------------------------
    // 4. GET THREADS (AMBIL DISKUSI KOMUNITAS)
    // ---------------------------------------------------------
    if ($action === 'get_threads') {
        // Cek dulu apakah tabel threads sudah ada (biar gak error fatal)
        $check = $conn->query("SHOW TABLES LIKE 'threads'");
        if($check->num_rows == 0) { echo json_encode(['status'=>'ok', 'data'=>[]]); exit; }

        // Ambil thread terbaru
        $sql = "SELECT * FROM threads ORDER BY created_at DESC";
        $result = $conn->query($sql);
        
        $threads = [];
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $t_id = $row['id'];
                
                // Ambil balasan (replies) untuk thread ini
                $rep_sql = "SELECT author, text, created_at FROM replies WHERE thread_id = $t_id ORDER BY created_at ASC";
                $rep_res = $conn->query($rep_sql);
                
                $replies = [];
                if ($rep_res) {
                    while($r_row = $rep_res->fetch_assoc()){
                        $replies[] = [
                            'author' => '@' . htmlspecialchars($r_row['author']),
                            'text'   => htmlspecialchars($r_row['text']),
                            'time'   => time_elapsed_string($r_row['created_at'])
                        ];
                    }
                }

                $threads[] = [
                    'id'      => $row['id'],
                    'author'  => '@' . htmlspecialchars($row['author']),
                    'title'   => htmlspecialchars($row['title']),
                    'tag'     => htmlspecialchars($row['tag']),
                    'content' => htmlspecialchars($row['content']),
                    'time'    => time_elapsed_string($row['created_at']),
                    'replies' => $replies
                ];
            }
        }
        echo json_encode(['status' => 'ok', 'data' => $threads]);
        exit;
    }

    // ---------------------------------------------------------
    // 5. CREATE THREAD (BUAT DISKUSI BARU)
    // ---------------------------------------------------------
    if ($action === 'create_thread') {
        if (!isset($_SESSION['user'])) { die(json_encode(['status'=>'error', 'message'=>'Login dulu.'])); }
        
        $author  = $_SESSION['user'];
        $title   = trim($_POST['title']);
        $tag     = trim($_POST['tag']);
        $content = trim($_POST['content']);

        $stmt = $conn->prepare("INSERT INTO threads (author, title, tag, content) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $author, $title, $tag, $content);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal membuat diskusi.']);
        }
        exit;
    }

    // ---------------------------------------------------------
    // 6. CREATE REPLY (BALAS DISKUSI)
    // ---------------------------------------------------------
    if ($action === 'create_reply') {
        if (!isset($_SESSION['user'])) { die(json_encode(['status'=>'error', 'message'=>'Login dulu.'])); }

        $author    = $_SESSION['user'];
        $thread_id = (int)$_POST['thread_id'];
        $text      = trim($_POST['text']);

        $stmt = $conn->prepare("INSERT INTO replies (thread_id, author, text) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $thread_id, $author, $text);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal membalas.']);
        }
        exit;
    }

    // Default jika action tidak ditemukan
    echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
    exit;
}
?>