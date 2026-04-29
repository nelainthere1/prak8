<?php
// =============================================
// forum.php — Halaman Utama Forum
// =============================================
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$success = '';
$error   = '';

// ── HAPUS TOPIK ──────────────────────────────
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $hapusId = (int)$_GET['hapus'];

    if ($pdo) {
        // Hapus foto jika ada
        $stmt = $pdo->prepare("SELECT foto FROM topics WHERE id = ?");
        $stmt->execute([$hapusId]);
        $row = $stmt->fetch();
        if ($row && $row['foto'] && file_exists(UPLOAD_DIR . $row['foto'])) {
            unlink(UPLOAD_DIR . $row['foto']);
        }
        $pdo->prepare("DELETE FROM topics WHERE id = ?")->execute([$hapusId]);
    } else {
        // Hapus dari session storage
        $topics = $_SESSION['topics'] ?? [];
        $_SESSION['topics'] = array_values(array_filter($topics, fn($t) => $t['id'] !== $hapusId));
    }

    $success = 'Topik berhasil dihapus.';
}

// ── TAMBAH TOPIK ─────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah') {
    $judul     = trim($_POST['judul']     ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $penulis   = trim($_POST['penulis']   ?? '');
    $lokasi    = trim($_POST['lokasi']    ?? '');

    if (!$judul || !$deskripsi || !$penulis || !$lokasi) {
        $error = 'Judul, deskripsi, nama, dan lokasi wajib diisi.';
    } else {
        // Handle upload foto
        $fotoNama = null;
        if (!empty($_FILES['foto']['name'])) {
            $ext   = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $allow = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($ext, $allow)) {
                $error = 'Format foto tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.';
            } elseif ($_FILES['foto']['size'] > 5 * 1024 * 1024) {
                $error = 'Ukuran foto maksimal 5 MB.';
            } else {
                $fotoNama = uniqid('foto_', true) . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], UPLOAD_DIR . $fotoNama);
            }
        }

        if (!$error) {
            if ($pdo) {
                $stmt = $pdo->prepare("
                    INSERT INTO topics (judul, deskripsi, penulis, lokasi, foto)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([$judul, $deskripsi, $penulis, $lokasi, $fotoNama]);
            } else {
                // Simpan di session jika tidak ada DB
                if (!isset($_SESSION['topics'])) {
                    $_SESSION['topics'] = getDefaultTopics();
                }
                $newId = time();
                array_unshift($_SESSION['topics'], [
                    'id'         => $newId,
                    'judul'      => $judul,
                    'deskripsi'  => $deskripsi,
                    'penulis'    => $penulis,
                    'lokasi'     => $lokasi,
                    'foto'       => $fotoNama,
                    'balasan'    => 0,
                    'views'      => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            $success = 'Topik berhasil dibuat! 🎉';
        }
    }
}

// ── AMBIL DAFTAR TOPIK ────────────────────────
function getDefaultTopics(): array {
    return [
        ['id'=>1,'judul'=>'Tips Mengelola Waktu Layar Anak di Era Digital','deskripsi'=>'Bagaimana cara membatasi waktu anak menggunakan gadget tanpa konflik? Yuk berbagi pengalaman!','penulis'=>'Seli','lokasi'=>'Jakarta','foto'=>null,'balasan'=>12,'views'=>45,'created_at'=>date('Y-m-d H:i:s', strtotime('-2 days'))],
        ['id'=>2,'judul'=>'Pengalaman Parenting di Tengah Pandemi','deskripsi'=>'Mari berbagi cerita dan tips menghadapi homeschooling dan work from home bersama anak.','penulis'=>'Irfan','lokasi'=>'Bandung','foto'=>null,'balasan'=>8,'views'=>32,'created_at'=>date('Y-m-d H:i:s', strtotime('-5 days'))],
        ['id'=>3,'judul'=>'Edukasi Seksual untuk Anak Remaja','deskripsi'=>'Bagaimana cara membicarakan topik sensitif ini dengan anak tanpa canggung?','penulis'=>'Glory','lokasi'=>'Yogyakarta','foto'=>null,'balasan'=>20,'views'=>87,'created_at'=>date('Y-m-d H:i:s', strtotime('-7 days'))],
        ['id'=>4,'judul'=>'Mendorong Kreativitas Anak Melalui Aktivitas Online','deskripsi'=>'Rekomendasi aplikasi dan website edukasi yang menyenangkan dan aman untuk anak-anak.','penulis'=>'Darnel','lokasi'=>'Surabaya','foto'=>null,'balasan'=>6,'views'=>28,'created_at'=>date('Y-m-d H:i:s', strtotime('-3 days'))],
    ];
}

if ($pdo) {
    $stmt   = $pdo->query("SELECT * FROM topics ORDER BY created_at DESC");
    $topics = $stmt->fetchAll();
} else {
    if (!isset($_SESSION['topics'])) {
        $_SESSION['topics'] = getDefaultTopics();
    }
    $topics = $_SESSION['topics'];
}

// Helper: waktu relatif
function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)          return 'Baru saja';
    if ($diff < 3600)        return floor($diff / 60)   . ' menit yang lalu';
    if ($diff < 86400)       return floor($diff / 3600) . ' jam yang lalu';
    if ($diff < 604800)      return floor($diff / 86400). ' hari yang lalu';
    return date('d M Y', strtotime($datetime));
}

$pageTitle = 'Forum Diskusi';
require_once 'header.php';
?>

<!-- HERO -->
<div class="hero">
  <h1>Forum Orang Tua Digital</h1>
  <p class="sub-green">Tempat Berbagi Pengalaman &amp; Edukasi Parenting Modern</p>
  <p class="sub-gray">Bergabunglah dengan komunitas orang tua untuk berbagi tips, pengalaman, dan dukungan dalam mendidik anak di era digital.</p>
</div>

<!-- FORUM SECTION -->
<div class="forum-section">

  <!-- Toolbar -->
  <div class="forum-toolbar">
    <h2>Topik Diskusi
      <small style="font-family:var(--font);font-size:14px;color:#aaa;font-weight:600">
        (<?= count($topics) ?> topik)
      </small>
    </h2>
    <button class="btn-green" onclick="toggleModal(true)">✏️ Buat Topik Baru</button>
  </div>

  <!-- Notifikasi -->
  <?php if ($success): ?>
    <div class="alert alert-ok">✅ <?= e($success) ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-err">⚠️ <?= e($error) ?></div>
  <?php endif; ?>

  <!-- Daftar Topik -->
  <?php if (empty($topics)): ?>
    <div class="empty-state">
      <div class="icon">💬</div>
      <p>Belum ada topik diskusi. Jadilah yang pertama membuat topik!</p>
    </div>
  <?php else: ?>
    <div class="topics-list">
      <?php foreach ($topics as $i => $topic): ?>
        <div class="topic-card">
          <div class="topic-header">
            <div style="flex:1">
              <div class="topic-title"><?= e($topic['judul']) ?></div>
              <div class="topic-desc"><?= e($topic['deskripsi']) ?></div>
              <div class="topic-meta">
                Oleh: <span><?= e($topic['penulis']) ?>, <?= e($topic['lokasi']) ?></span>
                — <?= timeAgo($topic['created_at']) ?>
              </div>
            </div>
            <div class="topic-stats">
              <p><?= (int)$topic['balasan'] ?> Balasan</p>
              <p><?= (int)$topic['views']   ?> Views</p>
            </div>
          </div>

          <?php if (!empty($topic['foto'])): ?>
            <img class="topic-photo"
                 src="<?= e(UPLOAD_URL . $topic['foto']) ?>"
                 alt="Foto topik <?= e($topic['judul']) ?>">
          <?php endif; ?>

          <div class="topic-actions">
            <a href="#" class="btn-action btn-read">Baca</a>
            <a href="#" class="btn-action btn-read">Balas</a>
            <a href="forum.php?hapus=<?= (int)$topic['id'] ?>"
               class="btn-action btn-delete"
               onclick="return confirm('Yakin hapus topik ini?')">Hapus</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>

<!-- =====================
     MODAL BUAT TOPIK
===================== -->
<div class="modal-overlay" id="modalOverlay" style="display:none;position:fixed;inset:0;background:rgba(46,7,73,0.4);backdrop-filter:blur(4px);align-items:center;justify-content:center;z-index:200;padding:1rem;">
  <div class="modal-box" style="background:white;border-radius:18px;box-shadow:0 16px 60px rgba(142,68,173,0.25);padding:2rem;width:100%;max-width:500px;max-height:90vh;overflow-y:auto;">
    <h3 style="font-family:var(--serif);font-size:22px;color:var(--purple);margin-bottom:1.25rem;">✏️ Buat Topik Baru</h3>

    <?php if ($error): ?>
      <div class="alert alert-err">⚠️ <?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="forum.php" enctype="multipart/form-data">
      <input type="hidden" name="action" value="tambah">

      <div class="fi">
        <label for="judul">Judul Topik</label>
        <input type="text" id="judul" name="judul" placeholder="Masukkan judul topik..." required>
      </div>

      <div class="fi">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Ceritakan topik Anda..." required></textarea>
      </div>

      <div class="form-row">
        <div class="fi">
          <label for="penulis">Nama Anda</label>
          <input type="text" id="penulis" name="penulis"
                 value="<?= e($_SESSION['user']['nama']) ?>" required>
        </div>
        <div class="fi">
          <label for="lokasi">Lokasi</label>
          <input type="text" id="lokasi" name="lokasi" placeholder="Kota Anda" required>
        </div>
      </div>

      <div class="fi">
        <label>Foto (Opsional)</label>
        <label class="upload-zone" id="uploadZone" for="foto">
          <input type="file" id="foto" name="foto" accept="image/*" style="display:none" onchange="previewFoto(this)">
          <div class="uz-icon">🖼️</div>
          <div class="uz-label">Klik untuk pilih foto (maks. 5MB)</div>
          <div id="uzName" style="font-size:12px;color:var(--green-dark);font-weight:700;margin-top:4px;"></div>
        </label>
        <img id="fotoPreview" src="" alt="" style="display:none;max-height:160px;object-fit:cover;border-radius:10px;margin-top:8px;width:100%;">
      </div>

      <div style="display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.25rem;">
        <button type="button" onclick="toggleModal(false)"
                style="padding:9px 20px;background:#f0f0f0;border:none;border-radius:8px;color:var(--text2);font-size:13px;font-weight:600;cursor:pointer;font-family:var(--font);">
          Batal
        </button>
        <button type="submit"
                style="padding:9px 24px;background:linear-gradient(135deg,var(--green),var(--green-dark));border:none;border-radius:8px;color:white;font-size:13px;font-weight:700;cursor:pointer;font-family:var(--font);">
          Buat Topik
        </button>
      </div>
    </form>
  </div>
</div>

<?php require_once 'footer.php'; ?>

<script>
  function toggleModal(show) {
    const el = document.getElementById('modalOverlay');
    el.style.display = show ? 'flex' : 'none';
  }

  // Buka modal otomatis jika ada error dari POST
  <?php if ($error && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  toggleModal(true);
  <?php endif; ?>

  function previewFoto(input) {
    const file = input.files[0];
    if (!file) return;
    document.getElementById('uzName').textContent = '✅ ' + file.name;
    document.getElementById('uploadZone').classList.add('has-file');
    const reader = new FileReader();
    reader.onload = e => {
      const img = document.getElementById('fotoPreview');
      img.src = e.target.result;
      img.style.display = 'block';
    };
    reader.readAsDataURL(file);
  }

  // Tutup modal klik di luar
  document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) toggleModal(false);
  });
</script>
