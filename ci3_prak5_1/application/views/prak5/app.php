<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aku & Kamu — Forum Orang Tua Digital</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --lavender:    #E6E6FA;
      --lavender2:   #d4d4f5;
      --purple:      #8E44AD;
      --purple-dark: #7D3C98;
      --purple-soft: #c39bd3;
      --green:       #32CD32;
      --green-dark:  #28a428;
      --green-soft:  #d4f7d4;
      --white:       #FFFFFF;
      --text:        #2F4F4F;
      --text2:       #5a6868;
      --red:         #e74c3c;
      --shadow:      0 4px 20px rgba(142,68,173,0.12);
      --font:        'Nunito', sans-serif;
      --serif:       'DM Serif Display', serif;
    }

    body {
      font-family: var(--font);
      background: var(--lavender);
      color: var(--text);
      min-height: 100vh;
    }

    /* ===========================
       LOGIN PAGE
    =========================== */
    #loginPage {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #E6E6FA 0%, #f0fff0 50%, #e6e6fa 100%);
      position: relative;
      overflow: hidden;
    }
    #loginPage::before {
      content: '';
      position: absolute;
      width: 600px; height: 600px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(142,68,173,0.08) 0%, transparent 70%);
      top: -200px; right: -200px;
    }
    #loginPage::after {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(50,205,50,0.07) 0%, transparent 70%);
      bottom: -100px; left: -100px;
    }

    .login-card {
      background: var(--white);
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(142,68,173,0.18);
      padding: 2.5rem 2rem;
      width: 100%;
      max-width: 480px;
      position: relative;
      z-index: 1;
      animation: fadeUp 0.5s ease;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .login-brand {
      text-align: center;
      margin-bottom: 1.75rem;
    }
    .login-brand .logo-circle {
      width: 60px; height: 60px;
      background: linear-gradient(135deg, var(--purple), var(--green));
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-family: var(--serif);
      font-size: 22px;
      color: white;
      margin-bottom: 0.75rem;
    }
    .login-brand h1 {
      font-family: var(--serif);
      font-size: 26px;
      color: var(--purple);
    }
    .login-brand p {
      font-size: 13px;
      color: var(--green);
      margin-top: 4px;
      font-weight: 600;
    }

    .login-divider {
      text-align: center;
      font-size: 12px;
      color: #aaa;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .login-divider::before, .login-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e0e0e0;
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .form-row.full { grid-template-columns: 1fr; }

    .fi {
      display: flex;
      flex-direction: column;
      gap: 5px;
      margin-bottom: 0.85rem;
    }
    .fi label {
      font-size: 12px;
      font-weight: 700;
      color: var(--purple);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .fi input, .fi select, .fi textarea {
      padding: 10px 12px;
      border: 1.5px solid #ddd;
      border-radius: 9px;
      font-size: 14px;
      font-family: var(--font);
      color: var(--text);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      background: #fafafa;
    }
    .fi input:focus, .fi select:focus, .fi textarea:focus {
      border-color: var(--purple);
      box-shadow: 0 0 0 3px rgba(142,68,173,0.1);
      background: white;
    }
    .fi textarea { resize: vertical; min-height: 72px; }

    .btn-primary {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, var(--purple), var(--purple-dark));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      font-family: var(--font);
      transition: all 0.2s;
      margin-top: 0.5rem;
      letter-spacing: 0.3px;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--purple-dark), #6c3483);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(142,68,173,0.3);
    }
    .login-err {
      font-size: 12px;
      color: var(--red);
      text-align: center;
      margin-top: 0.5rem;
      display: none;
      font-weight: 600;
    }

    /* ===========================
       MAIN APP
    =========================== */
    #mainApp { display: none; flex-direction: column; min-height: 100vh; }

    /* NAVBAR */
    .navbar {
      background: var(--white);
      box-shadow: 0 2px 16px rgba(142,68,173,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
      padding: 0 1.5rem;
      height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .nav-brand {
      font-family: var(--serif);
      font-size: 22px;
      color: var(--purple);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .nav-brand .dot {
      width: 10px; height: 10px;
      border-radius: 50%;
      background: var(--green);
      display: inline-block;
    }
    .nav-right { display: flex; align-items: center; gap: 12px; }
    .badge-user {
      background: var(--lavender);
      border: 1.5px solid var(--purple-soft);
      border-radius: 20px;
      padding: 5px 14px;
      font-size: 13px;
      color: var(--purple);
      font-weight: 700;
    }
    .btn-logout {
      padding: 6px 14px;
      background: transparent;
      border: 1.5px solid #ddd;
      border-radius: 8px;
      color: var(--text2);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: var(--font);
      transition: all 0.2s;
    }
    .btn-logout:hover { border-color: var(--red); color: var(--red); }

    /* HERO SECTION */
    .hero {
      background: linear-gradient(135deg, rgba(230,230,250,0.9), rgba(240,255,240,0.9));
      padding: 3.5rem 1.5rem 2.5rem;
      text-align: center;
      border-bottom: 1px solid var(--lavender2);
    }
    .hero h1 {
      font-family: var(--serif);
      font-size: clamp(28px, 5vw, 48px);
      color: var(--purple);
      margin-bottom: 0.75rem;
    }
    .hero p {
      font-size: clamp(14px, 2.5vw, 18px);
      color: var(--green-dark);
      font-weight: 600;
      max-width: 600px;
      margin: 0 auto 0.5rem;
    }
    .hero .sub {
      font-size: 14px;
      color: var(--text2);
      max-width: 520px;
      margin: 0 auto;
      font-weight: 400;
    }

    /* FORUM SECTION */
    .forum-section {
      max-width: 860px;
      margin: 0 auto;
      padding: 2rem 1.5rem 4rem;
      flex: 1;
    }

    .forum-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .forum-toolbar h2 {
      font-family: var(--serif);
      font-size: 24px;
      color: var(--purple);
    }
    .btn-new-topic {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 10px 20px;
      background: linear-gradient(135deg, var(--green), var(--green-dark));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      font-family: var(--font);
      transition: all 0.2s;
    }
    .btn-new-topic:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(50,205,50,0.3);
    }

    /* TOPIC CARD */
    .topics-list { display: flex; flex-direction: column; gap: 1rem; }

    .topic-card {
      background: white;
      border-radius: 14px;
      box-shadow: var(--shadow);
      border-left: 4px solid var(--purple);
      padding: 1.25rem 1.5rem;
      transition: transform 0.15s, box-shadow 0.15s;
      animation: fadeUp 0.3s ease;
    }
    .topic-card:nth-child(even) { border-left-color: var(--green); }
    .topic-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(142,68,173,0.15); }

    .topic-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 0.6rem; }
    .topic-title {
      font-size: 16px;
      font-weight: 700;
      color: var(--purple);
      line-height: 1.4;
    }
    .topic-card:nth-child(even) .topic-title { color: var(--green-dark); }
    .topic-desc { font-size: 13.5px; color: var(--text2); margin-bottom: 0.75rem; line-height: 1.5; }
    .topic-meta { font-size: 12px; color: #999; font-weight: 600; }
    .topic-meta span { color: var(--purple); }
    .topic-card:nth-child(even) .topic-meta span { color: var(--green-dark); }

    .topic-photo {
      width: 100%;
      max-height: 220px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 0.75rem;
    }

    .topic-stats { font-size: 12px; color: #bbb; white-space: nowrap; text-align: right; }
    .topic-stats p { line-height: 1.6; }

    .topic-actions { display: flex; gap: 0.75rem; margin-top: 0.75rem; flex-wrap: wrap; }
    .btn-action {
      padding: 5px 14px;
      border-radius: 20px;
      font-size: 12.5px;
      font-weight: 700;
      cursor: pointer;
      border: 1.5px solid;
      font-family: var(--font);
      transition: all 0.15s;
      background: transparent;
    }
    .btn-read  { border-color: var(--purple); color: var(--purple); }
    .btn-read:hover { background: var(--purple); color: white; }
    .topic-card:nth-child(even) .btn-read { border-color: var(--green-dark); color: var(--green-dark); }
    .topic-card:nth-child(even) .btn-read:hover { background: var(--green-dark); color: white; }
    .btn-reply { border-color: var(--green-dark); color: var(--green-dark); }
    .btn-reply:hover { background: var(--green-dark); color: white; }
    .btn-delete { border-color: var(--red); color: var(--red); }
    .btn-delete:hover { background: var(--red); color: white; }

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: var(--text2);
      display: none;
    }
    .empty-state .icon { font-size: 48px; margin-bottom: 1rem; }
    .empty-state p { font-size: 15px; }

    /* ===========================
       MODAL
    =========================== */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(46,7,73,0.35);
      backdrop-filter: blur(4px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 200;
      padding: 1rem;
    }
    .modal-overlay.open { display: flex; }

    .modal-box {
      background: white;
      border-radius: 18px;
      box-shadow: 0 16px 60px rgba(142,68,173,0.25);
      padding: 2rem;
      width: 100%;
      max-width: 500px;
      max-height: 90vh;
      overflow-y: auto;
      animation: fadeUp 0.3s ease;
    }
    .modal-box h3 {
      font-family: var(--serif);
      font-size: 22px;
      color: var(--purple);
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .upload-zone {
      border: 2px dashed var(--purple-soft);
      border-radius: 12px;
      padding: 1.25rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s;
      background: var(--lavender);
    }
    .upload-zone:hover { border-color: var(--purple); background: rgba(142,68,173,0.05); }
    .upload-zone.has-file { border-color: var(--green); background: rgba(50,205,50,0.05); }
    .upload-zone input { display: none; }
    .upload-zone .uz-icon { font-size: 28px; margin-bottom: 6px; }
    .upload-zone .uz-label { font-size: 13px; color: var(--text2); }
    .upload-zone .uz-name { font-size: 12px; color: var(--green-dark); font-weight: 700; margin-top: 4px; }

    .modal-actions {
      display: flex;
      gap: 0.75rem;
      margin-top: 1.25rem;
      justify-content: flex-end;
    }
    .btn-modal-cancel {
      padding: 9px 20px;
      background: #f0f0f0;
      border: none;
      border-radius: 8px;
      color: var(--text2);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: var(--font);
    }
    .btn-modal-submit {
      padding: 9px 24px;
      background: linear-gradient(135deg, var(--green), var(--green-dark));
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      font-family: var(--font);
      transition: all 0.2s;
    }
    .btn-modal-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(50,205,50,0.3); }

    /* TOAST */
    #toast {
      position: fixed;
      bottom: 1.5rem;
      right: 1.5rem;
      padding: 12px 20px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      display: none;
      z-index: 999;
      animation: fadeUp 0.3s ease;
    }
    #toast.ok  { background: var(--green);  color: white; }
    #toast.err { background: var(--red);    color: white; }

    /* FOOTER */
    footer {
      background: var(--lavender2);
      border-top: 1px solid var(--purple-soft);
      padding: 1.5rem;
      text-align: center;
      font-size: 13px;
      color: var(--purple);
    }
    footer span { color: var(--green-dark); font-weight: 700; }

    @media (max-width: 500px) {
      .form-row { grid-template-columns: 1fr; }
      .topic-header { flex-direction: column; }
      .topic-stats { text-align: left; }
    }
  </style>
</head>
<body>

<!-- =====================
     LOGIN PAGE
===================== -->
<div id="loginPage">
  <div class="login-card">
    <div class="login-brand">
      <div class="logo-circle">A&K</div>
      <h1>Aku & Kamu</h1>
      <p>Daftar sebagai Relawan untuk bergabung</p>
    </div>

    <div class="login-divider">Isi data diri Anda</div>

    <div class="form-row">
      <div class="fi">
        <label for="lNama">Nama Lengkap</label>
        <input type="text" id="lNama" placeholder="Nama Anda" required>
      </div>
      <div class="fi">
        <label for="lUsia">Usia</label>
        <input type="number" id="lUsia" placeholder="Min. 18" min="18" required>
      </div>
    </div>
    <div class="fi">
      <label for="lEmail">Email</label>
      <input type="email" id="lEmail" placeholder="email@contoh.com" required>
    </div>
    <div class="fi">
      <label for="lTelepon">Nomor Telepon</label>
      <input type="tel" id="lTelepon" placeholder="+62..." required>
    </div>
    <div class="fi">
      <label for="lKategori">Kategori Bantuan</label>
      <select id="lKategori" required>
        <option value="">Pilih Kategori</option>
        <option value="anak-anak">Anak-anak</option>
        <option value="lansia">Lansia</option>
        <option value="keluarga">Keluarga</option>
        <option value="semua">Semua</option>
      </select>
    </div>
    <div class="fi">
      <label for="lAlasan">Alasan Mendaftar</label>
      <textarea id="lAlasan" rows="3" placeholder="Ceritakan motivasi Anda menjadi relawan..." required></textarea>
    </div>

    <button class="btn-primary" onclick="doLogin()">🌸 Daftar & Masuk</button>
    <div id="loginErr" class="login-err">Mohon lengkapi semua field dengan benar.</div>
  </div>
</div>

<!-- =====================
     MAIN APP
===================== -->
<div id="mainApp">

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-brand">
      <span class="dot"></span>
      Aku & Kamu
    </div>
    <div class="nav-right">
      <span class="badge-user" id="badgeUser">Relawan</span>
      <button class="btn-logout" onclick="doLogout()">Keluar</button>
    </div>
  </nav>

  <!-- HERO -->
  <div class="hero">
    <h1>Forum Orang Tua Digital</h1>
    <p>Tempat Berbagi Pengalaman & Edukasi Parenting Modern</p>
    <p class="sub">Bergabunglah dengan komunitas orang tua untuk berbagi tips, pengalaman, dan dukungan dalam mendidik anak di era digital.</p>
  </div>

  <!-- FORUM -->
  <div class="forum-section">
    <div class="forum-toolbar">
      <h2>Topik Diskusi</h2>
      <button class="btn-new-topic" onclick="openModal()">
        ✏️ Buat Topik Baru
      </button>
    </div>

    <div class="topics-list" id="topicsList">
      <!-- Default topics -->
      <div class="topic-card">
        <div class="topic-header">
          <div>
            <div class="topic-title">Tips Mengelola Waktu Layar Anak di Era Digital</div>
            <div class="topic-desc">Bagaimana cara membatasi waktu anak menggunakan gadget tanpa konflik? Yuk berbagi pengalaman!</div>
            <div class="topic-meta">Oleh: <span>Seli, Jakarta</span> — 2 hari yang lalu</div>
          </div>
          <div class="topic-stats"><p>12 Balasan</p><p>45 Views</p></div>
        </div>
        <div class="topic-actions">
          <button class="btn-action btn-read">Baca</button>
          <button class="btn-action btn-reply">Balas</button>
          <button class="btn-action btn-delete" onclick="deleteTopic(this)">Hapus</button>
        </div>
      </div>

      <div class="topic-card">
        <div class="topic-header">
          <div>
            <div class="topic-title">Pengalaman Parenting di Tengah Pandemi</div>
            <div class="topic-desc">Mari berbagi cerita dan tips menghadapi homeschooling dan work from home bersama anak.</div>
            <div class="topic-meta">Oleh: <span>Irfan, Bandung</span> — 5 hari yang lalu</div>
          </div>
          <div class="topic-stats"><p>8 Balasan</p><p>32 Views</p></div>
        </div>
        <div class="topic-actions">
          <button class="btn-action btn-read">Baca</button>
          <button class="btn-action btn-reply">Balas</button>
          <button class="btn-action btn-delete" onclick="deleteTopic(this)">Hapus</button>
        </div>
      </div>

      <div class="topic-card">
        <div class="topic-header">
          <div>
            <div class="topic-title">Edukasi Seksual untuk Anak Remaja</div>
            <div class="topic-desc">Bagaimana cara membicarakan topik sensitif ini dengan anak tanpa canggung?</div>
            <div class="topic-meta">Oleh: <span>Glory, Yogyakarta</span> — 1 minggu yang lalu</div>
          </div>
          <div class="topic-stats"><p>20 Balasan</p><p>87 Views</p></div>
        </div>
        <div class="topic-actions">
          <button class="btn-action btn-read">Baca</button>
          <button class="btn-action btn-reply">Balas</button>
          <button class="btn-action btn-delete" onclick="deleteTopic(this)">Hapus</button>
        </div>
      </div>

      <div class="topic-card">
        <div class="topic-header">
          <div>
            <div class="topic-title">Mendorong Kreativitas Anak Melalui Aktivitas Online</div>
            <div class="topic-desc">Rekomendasi aplikasi dan website edukasi yang menyenangkan dan aman untuk anak-anak.</div>
            <div class="topic-meta">Oleh: <span>Darnel, Surabaya</span> — 3 hari yang lalu</div>
          </div>
          <div class="topic-stats"><p>6 Balasan</p><p>28 Views</p></div>
        </div>
        <div class="topic-actions">
          <button class="btn-action btn-read">Baca</button>
          <button class="btn-action btn-reply">Balas</button>
          <button class="btn-action btn-delete" onclick="deleteTopic(this)">Hapus</button>
        </div>
      </div>
    </div>

    <div class="empty-state" id="emptyState">
      <div class="icon">💬</div>
      <p>Belum ada topik diskusi. Jadilah yang pertama membuat topik!</p>
    </div>
  </div>

  <footer>
    &copy; 2025 <span>Aku & Kamu</span>. Semua hak dilindungi. — Menghubungkan Keluarga di Dunia Digital
  </footer>
</div>

<!-- =====================
     MODAL BUAT TOPIK
===================== -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal-box">
    <h3>✏️ Buat Topik Baru</h3>

    <div class="fi">
      <label for="tJudul">Judul Topik</label>
      <input type="text" id="tJudul" placeholder="Masukkan judul topik..." required>
    </div>
    <div class="fi">
      <label for="tDeskripsi">Deskripsi</label>
      <textarea id="tDeskripsi" rows="4" placeholder="Ceritakan topik Anda..." required></textarea>
    </div>
    <div class="form-row">
      <div class="fi">
        <label for="tPenulis">Nama Anda</label>
        <input type="text" id="tPenulis" placeholder="Nama" required>
      </div>
      <div class="fi">
        <label for="tLokasi">Lokasi</label>
        <input type="text" id="tLokasi" placeholder="Kota Anda" required>
      </div>
    </div>

    <div class="fi">
      <label>Foto (Opsional)</label>
      <div class="upload-zone" id="uploadZone" onclick="document.getElementById('tFoto').click()">
        <input type="file" id="tFoto" accept="image/*" onchange="handlePhoto(this)">
        <div class="uz-icon">🖼️</div>
        <div class="uz-label">Klik untuk pilih foto</div>
        <div class="uz-name" id="uzName"></div>
      </div>
    </div>

    <div class="modal-actions">
      <button class="btn-modal-cancel" onclick="closeModal()">Batal</button>
      <button class="btn-modal-submit" onclick="submitTopic()">Buat Topik</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script>
  let currentUser = '';
  let photoDataUrl = null;
  let topicCount = 4;

  // ===== LOGIN =====
  function doLogin() {
    const nama     = document.getElementById('lNama').value.trim();
    const email    = document.getElementById('lEmail').value.trim();
    const telepon  = document.getElementById('lTelepon').value.trim();
    const usia     = parseInt(document.getElementById('lUsia').value);
    const kategori = document.getElementById('lKategori').value;
    const alasan   = document.getElementById('lAlasan').value.trim();

    if (!nama || !email || !telepon || !usia || !kategori || !alasan || usia < 18) {
      document.getElementById('loginErr').style.display = 'block';
      return;
    }
    document.getElementById('loginErr').style.display = 'none';

    currentUser = nama;
    document.getElementById('badgeUser').textContent = nama;
    document.getElementById('tPenulis').value = nama;

    document.getElementById('loginPage').style.display = 'none';
    document.getElementById('mainApp').style.display = 'flex';
    document.getElementById('mainApp').style.flexDirection = 'column';

    showToast('Selamat datang, ' + nama + '! 🌸', 'ok');
  }

  // ===== LOGOUT =====
  function doLogout() {
    document.getElementById('mainApp').style.display = 'none';
    document.getElementById('loginPage').style.display = 'flex';
    // Reset login form
    ['lNama','lEmail','lTelepon','lUsia','lAlasan'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('lKategori').value = '';
    currentUser = '';
  }

  // ===== MODAL =====
  function openModal() {
    photoDataUrl = null;
    document.getElementById('tJudul').value = '';
    document.getElementById('tDeskripsi').value = '';
    document.getElementById('tLokasi').value = '';
    document.getElementById('tFoto').value = '';
    document.getElementById('uzName').textContent = '';
    document.getElementById('uploadZone').classList.remove('has-file');
    document.getElementById('modalOverlay').classList.add('open');
  }
  function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
  }

  function handlePhoto(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      photoDataUrl = e.target.result;
      document.getElementById('uzName').textContent = '✅ ' + file.name;
      document.getElementById('uploadZone').classList.add('has-file');
    };
    reader.readAsDataURL(file);
  }

  // ===== CREATE TOPIC =====
  function submitTopic() {
    const judul   = document.getElementById('tJudul').value.trim();
    const desc    = document.getElementById('tDeskripsi').value.trim();
    const penulis = document.getElementById('tPenulis').value.trim() || currentUser;
    const lokasi  = document.getElementById('tLokasi').value.trim();

    if (!judul || !desc || !lokasi) {
      showToast('Judul, deskripsi, dan lokasi wajib diisi!', 'err');
      return;
    }

    topicCount++;
    const isEven = topicCount % 2 === 0;

    const card = document.createElement('div');
    card.className = 'topic-card';
    card.innerHTML = `
      <div class="topic-header">
        <div>
          <div class="topic-title">${escHtml(judul)}</div>
          <div class="topic-desc">${escHtml(desc)}</div>
          <div class="topic-meta">Oleh: <span>${escHtml(penulis)}, ${escHtml(lokasi)}</span> — Baru saja</div>
        </div>
        <div class="topic-stats"><p>0 Balasan</p><p>0 Views</p></div>
      </div>
      ${photoDataUrl ? `<img class="topic-photo" src="${photoDataUrl}" alt="Foto topik">` : ''}
      <div class="topic-actions">
        <button class="btn-action btn-read">Baca</button>
        <button class="btn-action btn-reply">Balas</button>
        <button class="btn-action btn-delete" onclick="deleteTopic(this)">Hapus</button>
      </div>
    `;

    document.getElementById('topicsList').appendChild(card);
    checkEmpty();
    closeModal();
    showToast('Topik berhasil dibuat! 🎉', 'ok');
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  // ===== DELETE TOPIC =====
  function deleteTopic(btn) {
    const card = btn.closest('.topic-card');
    card.style.transition = 'opacity 0.3s, transform 0.3s';
    card.style.opacity = '0';
    card.style.transform = 'translateX(20px)';
    setTimeout(() => { card.remove(); checkEmpty(); }, 300);
    showToast('Topik dihapus.', 'ok');
  }

  function checkEmpty() {
    const list = document.getElementById('topicsList');
    document.getElementById('emptyState').style.display =
      list.children.length === 0 ? 'block' : 'none';
  }

  // ===== TOAST =====
  function showToast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = type;
    t.style.display = 'block';
    clearTimeout(t._t);
    t._t = setTimeout(() => t.style.display = 'none', 3000);
  }

  // ===== ESCAPE HTML =====
  function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
</script>
</body>
</html>