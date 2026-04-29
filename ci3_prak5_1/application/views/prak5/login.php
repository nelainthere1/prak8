<?php
// =============================================
// login.php — Pendaftaran & Login Volunteer
// =============================================
require_once 'config.php';

// Jika sudah login, langsung ke forum
if (isLoggedIn()) {
    redirect('forum.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telepon  = trim($_POST['telepon']  ?? '');
    $usia     = (int)($_POST['usia']    ?? 0);
    $kategori = trim($_POST['kategori'] ?? '');
    $alasan   = trim($_POST['alasan']   ?? '');

    // Validasi
    if (!$nama || !$email || !$telepon || !$usia || !$kategori || !$alasan) {
        $error = 'Semua field wajib diisi.';
    } elseif ($usia < 18) {
        $error = 'Usia minimal 18 tahun.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        // Simpan ke DB jika tersedia, atau simpan ke session
        if ($pdo) {
            try {
                // Cek apakah email sudah terdaftar
                $stmt = $pdo->prepare("SELECT id FROM volunteers WHERE email = ?");
                $stmt->execute([$email]);
                $existing = $stmt->fetch();

                if (!$existing) {
                    // Insert volunteer baru
                    $stmt = $pdo->prepare("
                        INSERT INTO volunteers (nama, email, telepon, usia, kategori, alasan)
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$nama, $email, $telepon, $usia, $kategori, $alasan]);
                }
            } catch (PDOException $e) {
                // Lanjutkan meski DB error
            }
        }

        // Simpan ke session
        $_SESSION['user'] = [
            'nama'     => $nama,
            'email'    => $email,
            'kategori' => $kategori,
        ];

        redirect('forum.php');
    }
}

$pageTitle = 'Daftar Volunteer';
require_once 'header.php';
?>

<div class="login-page">
  <div class="login-card">

    <div class="login-brand">
      <div class="logo-circle">A&amp;K</div>
      <h1>Aku &amp; Kamu</h1>
      <p>Daftar sebagai Relawan untuk bergabung</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-err">⚠️ <?= e($error) ?></div>
    <?php endif; ?>

    <div class="login-divider">Isi data diri Anda</div>

    <form method="POST" action="login.php">
      <div class="form-row">
        <div class="fi">
          <label for="nama">Nama Lengkap</label>
          <input type="text" id="nama" name="nama"
                 value="<?= e($_POST['nama'] ?? '') ?>"
                 placeholder="Nama Anda" required>
        </div>
        <div class="fi">
          <label for="usia">Usia</label>
          <input type="number" id="usia" name="usia"
                 value="<?= e($_POST['usia'] ?? '') ?>"
                 placeholder="Min. 18" min="18" required>
        </div>
      </div>

      <div class="fi">
        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               value="<?= e($_POST['email'] ?? '') ?>"
               placeholder="email@contoh.com" required>
      </div>

      <div class="fi">
        <label for="telepon">Nomor Telepon</label>
        <input type="tel" id="telepon" name="telepon"
               value="<?= e($_POST['telepon'] ?? '') ?>"
               placeholder="+62..." required>
      </div>

      <div class="fi">
        <label for="kategori">Kategori Bantuan</label>
        <select id="kategori" name="kategori" required>
          <option value="">Pilih Kategori</option>
          <?php
          $opts = ['anak-anak' => 'Anak-anak', 'lansia' => 'Lansia', 'keluarga' => 'Keluarga', 'semua' => 'Semua'];
          foreach ($opts as $val => $label):
            $sel = (($_POST['kategori'] ?? '') === $val) ? 'selected' : '';
          ?>
          <option value="<?= $val ?>" <?= $sel ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="fi">
        <label for="alasan">Alasan Mendaftar</label>
        <textarea id="alasan" name="alasan" rows="3"
                  placeholder="Ceritakan motivasi Anda menjadi relawan..." required><?= e($_POST['alasan'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="btn-primary">🌸 Daftar &amp; Masuk</button>
    </form>

  </div>
</div>

<?php require_once 'footer.php'; ?>
