<?php
// =============================================
// install.php — Setup Database Aku & Kamu
// Jalankan sekali untuk membuat tabel
// =============================================

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'akukamu_db';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Buat database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$db`");

    // Tabel volunteer (pengguna)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `volunteers` (
            `id`       INT AUTO_INCREMENT PRIMARY KEY,
            `nama`     VARCHAR(100) NOT NULL,
            `email`    VARCHAR(150) NOT NULL UNIQUE,
            `telepon`  VARCHAR(20)  NOT NULL,
            `usia`     TINYINT      NOT NULL,
            `kategori` VARCHAR(50)  NOT NULL,
            `alasan`   TEXT         NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    // Tabel topik forum
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `topics` (
            `id`          INT AUTO_INCREMENT PRIMARY KEY,
            `judul`       VARCHAR(255) NOT NULL,
            `deskripsi`   TEXT         NOT NULL,
            `penulis`     VARCHAR(100) NOT NULL,
            `lokasi`      VARCHAR(100) NOT NULL,
            `foto`        VARCHAR(255) DEFAULT NULL,
            `balasan`     INT DEFAULT 0,
            `views`       INT DEFAULT 0,
            `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    // Seed: topik bawaan
    $pdo->exec("
        INSERT IGNORE INTO `topics` (`id`, `judul`, `deskripsi`, `penulis`, `lokasi`, `balasan`, `views`) VALUES
        (1, 'Tips Mengelola Waktu Layar Anak di Era Digital',
            'Bagaimana cara membatasi waktu anak menggunakan gadget tanpa konflik? Yuk berbagi pengalaman!',
            'Seli', 'Jakarta', 12, 45),
        (2, 'Pengalaman Parenting di Tengah Pandemi',
            'Mari berbagi cerita dan tips menghadapi homeschooling dan work from home bersama anak.',
            'Irfan', 'Bandung', 8, 32),
        (3, 'Edukasi Seksual untuk Anak Remaja',
            'Bagaimana cara membicarakan topik sensitif ini dengan anak tanpa canggung?',
            'Glory', 'Yogyakarta', 20, 87),
        (4, 'Mendorong Kreativitas Anak Melalui Aktivitas Online',
            'Rekomendasi aplikasi dan website edukasi yang menyenangkan dan aman untuk anak-anak.',
            'Darnel', 'Surabaya', 6, 28)
    ");

    echo "<h2 style='font-family:sans-serif;color:green'>✅ Database berhasil dibuat!</h2>";
    echo "<p style='font-family:sans-serif'>Tabel <b>volunteers</b> dan <b>topics</b> sudah siap.</p>";
    echo "<p style='font-family:sans-serif'><a href='login.php'>→ Pergi ke halaman Login</a></p>";

} catch (PDOException $e) {
    echo "<h2 style='font-family:sans-serif;color:red'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
}
