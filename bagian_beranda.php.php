<section id="home" class="hero">
  <div class="container hero-wrap">
    <div>
      <div class="pill"><span class="dot"></span><span id="chipText">
        <?php
          if ($user) {
            echo 'Selamat datang, <b>@'.htmlspecialchars($user, ENT_QUOTES, 'UTF-8').'</b> — mode komunitas aktif';
          } else {
            echo 'Mode Tamu — login untuk join diskusi komunitas';
          }
        ?>
      </span></div>

      <h1 class="headline">Tech Nirvana: Pilih <span class="c1">Cerdas</span>, Pintar <span class="c2">Nyata</span>, Fakta <span class="c3">Terbarukan</span></h1>
      <p class="lead">“Pilih Gadget yang Tepat Berdasarkan Rasa, Gaya, dan Kekuatan Teknologi!”.</p>
      <div class="cta">
        <a href="#categories" class="btn btn-primary" data-ripple>Jelajahi Kategori</a>
        <a href="#latest" class="btn" data-ripple>Lihat Terbaru</a>
      </div>

      <div class="rail">
        <div class="chip" data-stagger><i></i><span>Daily Driver</span></div>
        <div class="chip" data-stagger><i></i><span>Compact</span></div>
        <div class="chip" data-stagger><i></i><span>Gaming</span></div>
      </div>

      <div class="scroll-cta">
        <button class="btn-scroll" data-scroll-target="#categories">Explore Kategori ↓</button>
      </div>
    </div>

    <div>
      <div 
        class="cardx top-highlight-card" 
        id="topHighlight"
        data-gadget-id="3"
        style="border-radius:var(--r-2xl);display:flex;align-items:flex-start;justify-content:space-between;gap:18px"
        data-stagger
      >
        <div>
          <div class="badge" style="color:#9fb6ff">Top Highlight</div>
          <h3 style="margin:6px 0 4px">Xiaomi 17 Pro</h3>
          <div class="sub">Flagship • Rp15,5 Juta</div>
          <ul style="margin:14px 0 0 18px;color:#cfd8ff;font-size:14px">
            <li>Snapdragon 8 Gen 5 flagship</li>
            <li>Kamera 50MP + 50MP + 50MP dengan Leica</li>
            <li>Layar LTPO AMOLED 6,3" 120Hz HDR10+</li>
          </ul>
          <div class="cta" style="margin-top:16px">
            <a href="?page=consult" class="btn" data-page-link data-ripple>Minta Rekomendasi</a>
          </div>
        </div>
        <div class="card-thumb" style="width:88px;height:88px">
          <img src="https://www.ytechb.com/wp-content/uploads/2025/09/Xiaomi-17-wallpapers.webp" alt="Xiaomi 17 Pro">
        </div>
      </div>
    </div>
  </div>

  <div class="shine"></div>
</section>