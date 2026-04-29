<?php
// =============================================
// config.php — Konfigurasi Aplikasi Aku & Kamu
// =============================================

session_start();

// Konfigurasi Database (sesuaikan dengan server Anda)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'akukamu_db');

// Koneksi PDO
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Fallback: gunakan array session jika DB belum tersedia
    $pdo = null;
}

// Base URL aplikasi
define('BASE_URL', '/akukamu');

// Direktori upload foto
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', BASE_URL . '/uploads/');

// Pastikan folder uploads ada
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

// Helper: cek apakah sudah login
function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

// Helper: redirect
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

// Helper: escape HTML
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
