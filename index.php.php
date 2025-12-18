<?php
include "header.php";
?>

<?php
// =============================================================
// INDEX.PHP - Halaman Utama (Tanpa Komunitas & Tanpa Dock)
// =============================================================

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

/* ====== ROUTING HALAMAN ====== */
$allowedPages = ['home', 'categories', 'latest', 'consult', 'about', 'login'];

// Tentukan halaman default
$defaultPage = $user ? 'home' : 'login';

// Ambil halaman dari URL (?page=...), kalau tidak ada pakai default
$page = isset($_GET['page']) ? $_GET['page'] : $defaultPage;

// Keamanan: Kalau halaman tidak ada di daftar, balik ke default
if (!in_array($page, $allowedPages, true)) {
    $page = $defaultPage;
}

// Keamanan: Kalau belum login tapi maksa buka halaman lain, tendang ke login
if (!$user && $page !== 'login') {
    $page = 'login';
}
?>

<body>
  <div class="progress" id="progress"></div>
  <div class="film"></div>

  <div class="aurora-wrap" aria-hidden="true">
    <svg class="aurora" viewBox="0 0 1200 900" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="g1" x1="0" y1="0" x2="1200" y2="0">
          <stop class="linear-a" offset="0"/><stop class="linear-b" offset="1"/>
        </linearGradient>
        <linearGradient id="g2" x1="0" y1="900" x2="1200" y2="0">
          <stop class="linear-b" offset="0"/><stop class="linear-a" offset=".7"/><stop class="linear-c" offset="1"/>
        </linearGradient>
        <linearGradient id="g3" x1="1200" y1="0" x2="0" y2="900">
          <stop class="linear-c" offset="0"/><stop class="linear-b" offset="1"/>
        </linearGradient>
        <filter id="blur" x="-10%" y="-10%" width="120%" height="120%"><feGaussianBlur stdDeviation="28" /></filter>
      </defs>
      <g filter="url(#blur)" opacity=".9">
        <path d="M-60 420 Q 300 340 600 480 T 1260 460 L1260 900 L-60 900 Z" fill="url(#g1)"/>
        <path d="M-60 520 Q 280 600 600 520 T 1260 540 L1260 900 L-60 900 Z" fill="url(#g2)"/>
        <path d="M-60 640 Q 260 700 600 640 T 1260 640 L1260 900 L-60 900 Z" fill="url(#g3)"/>
      </g>
    </svg>
  </div>
  <div class="orb o1"></div>
  <div class="orb o2"></div>
  <div class="orb o3"></div>
  <canvas class="particles" id="particles"></canvas>
  <div class="cursor-aura" aria-hidden="true"></div>

  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

  <nav class="nav">
    <div class="container nav-inner">
      <a class="brand" href="?page=<?php echo $user ? 'home' : 'login'; ?>" data-page-link>
        <div class="logo">
          <img src="Logo-Tech-Nirvana.png" alt="Logo Tech Nirvana">
        </div>
        <div>
          <div class="title">Tech Nirvana</div>
          <div class="sub">Rekomendasi sesuai dengan kebutuhanmu!</div>
        </div>
      </a>

      <?php if ($user): ?>
      <div class="nav-links" id="navLinks">
        <a href="?page=home" data-page-link        <?php if ($page === 'home')         echo 'class="active"'; ?>>Beranda</a>
        <a href="?page=categories" data-page-link  <?php if ($page === 'categories')   echo 'class="active"'; ?>>Kategori</a>
        <a href="?page=latest" data-page-link      <?php if ($page === 'latest')       echo 'class="active"'; ?>>Terbaru</a>
        <a href="?page=consult" data-page-link     <?php if ($page === 'consult')      echo 'class="active"'; ?>>Konsultasi</a>
        <a href="?page=about" data-page-link       <?php if ($page === 'about')        echo 'class="active"'; ?>>Tentang</a>
      </div>
      <?php else: ?>
      <div class="nav-links" id="navLinks"></div>
      <?php endif; ?>

      <div class="actions">
        <span id="sessionInfo" class="sub">
          <?php echo $user ? "Hi, ".htmlspecialchars($user, ENT_QUOTES, 'UTF-8') : "Tamu"; ?>
        </span>

        <a href="?page=login" id="loginLink" class="btn" data-page-link>
          <?php echo $user ? "Ganti Username" : "Login"; ?>
        </a>

        <form id="logoutForm" method="post" style="display:inline-block">
          <input type="hidden" name="action" value="logout">
          <button id="logoutBtn" class="btn" style="display:<?php echo $user ? 'inline-block' : 'none'; ?>; margin-left:8px">
            Logout
          </button>
        </form>

        <button id="hamb" class="hamb" aria-label="Menu">☰</button>
      </div>
    </div>

    <div class="container mobile" id="mobile">
      <?php if ($user): ?>
        <a href="?page=home"       data-page-link>Beranda</a>
        <a href="?page=categories" data-page-link>Kategori</a>
        <a href="?page=latest"     data-page-link>Terbaru</a>
        <a href="?page=consult"    data-page-link>Konsultasi</a>
        <a href="?page=about"      data-page-link>Tentang</a>
      <?php endif; ?>
      <a href="?page=login" data-page-link><?php echo $user ? "Ganti Username" : "Login"; ?></a>
    </div>
  </nav>

  <?php if ($page === 'home'): ?>
    <?php include "bagian_beranda.php"; ?>
  <?php endif; ?>

  <?php if ($user && in_array($page, ['home', 'categories'], true)): ?>
    <?php include "bagian_kategori.php"; ?>
  <?php endif; ?>

  <?php if ($user && in_array($page, ['home','categories','latest'], true)): ?>
    <?php include "bagian_terbaru.php"; ?>
  <?php endif; ?>

  <?php if ($user && in_array($page, ['home','categories','latest','consult'], true)): ?>
    <?php include "bagian_konsultasi.php"; ?>
  <?php endif; ?>

  <?php if ($user && in_array($page, ['home','categories','latest','consult','about'], true)): ?>
    <?php include "bagian_tentang.php"; ?>
  <?php endif; ?>

  <?php if ($page === 'login'): ?>
    <?php include "login.php"; ?>
  <?php endif; ?>

  <footer>
    <div class="container">© <?php echo date('Y'); ?> Tech Nirvana • Dibuat dengan rasa oleh kreator.</div>
  </footer>

  <div id="detailModal" class="detail-modal" aria-hidden="true">
    <div class="detail-dialog">
      <button id="detailClose" class="detail-close" aria-label="Tutup detail">×</button>
      <div id="detailImageWrap">
        <img id="detailImage" src="" alt="">
      </div>
      <div>
        <h3 id="detailName" style="margin:0 0 6px;font-size:22px;font-weight:800"></h3>
        <div id="detailMeta" class="sub" style="margin-bottom:10px"></div>
        <ul id="detailSpecs" class="detail-specs"></ul>
      </div>
    </div>
  </div>

  <div id="toast" class="toast success"></div>

  <button class="totop" id="totop" title="Kembali ke atas">▲</button>

  <script>
    const SERVER_USER = <?php echo $user ? json_encode($user) : 'null'; ?>;
  </script>
  <script src="script.js?v=<?php echo time(); ?>"></script>

</body>
</html>