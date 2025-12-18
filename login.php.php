<section id="login" class="section" style="background:linear-gradient(180deg, rgba(15,24,43,.92), rgba(11,18,32,1))">
  <div class="container" style="max-width:640px;margin:0 auto">
    <div class="form-card">
      <h2>Masuk ke Tech Nirvana</h2>
      <p class="sub">Login atau daftar akun dulu untuk mengakses rekomendasi dan Komunitas Tech Nirvana.</p>

      <div class="auth-tabs">
        <button type="button" class="auth-tab active" data-auth="login">Masuk</button>
        <button type="button" class="auth-tab" data-auth="register">Daftar Akun</button>
      </div>

      <div class="auth-panels">
        <form id="loginPageForm" class="auth-panel is-active" data-auth="login">
          <label for="loginIdentifier" class="sub">Username / Email</label>
          <input id="loginIdentifier" class="input" placeholder="Contoh: fahrudin36 atau emailmu" />

          <div style="margin-top:var(--sp-3)">
            <label for="loginPassword" class="sub">Password</label>
            <input id="loginPassword" type="password" class="input" placeholder="Masukkan password" />
          </div>

          <div class="cta" style="margin-top:var(--sp-3)">
            <button type="submit" id="loginSubmit" class="btn btn-primary" data-ripple>Masuk</button>
          </div>
        </form>

        <form id="registerForm" class="auth-panel" data-auth="register">
          <label for="regEmail" class="sub">Email</label>
          <input id="regEmail" class="input" type="email" placeholder="contoh@email.com" />

          <div style="margin-top:var(--sp-3)">
            <label for="regUsername" class="sub">Username</label>
            <input id="regUsername" class="input" placeholder="Contoh: fahrudin36" />
          </div>

          <div style="margin-top:var(--sp-3)">
            <label for="regPassword" class="sub">Buat Password</label>
            <input id="regPassword" type="password" class="input" placeholder="Minimal 6 karakter, huruf & angka" />
          </div>

          <div style="margin-top:var(--sp-3)">
            <label for="regConfirm" class="sub">Konfirmasi Password</label>
            <input id="regConfirm" type="password" class="input" placeholder="Ulangi password" />
          </div>

          <p class="sub" style="margin-top:var(--sp-3);font-size:12px">
            Catatan: saat ini akun disimpan di server lokal (SESSION) untuk latihan. Nanti bisa disambungkan ke database MySQL.
          </p>

          <div class="cta" style="margin-top:var(--sp-3)">
            <button type="submit" id="registerSubmit" class="btn btn-primary" data-ripple>Daftar Akun</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>