<section id="consult" class="section" style="background:linear-gradient(180deg, rgba(15,24,43,.85), rgba(11,18,32,1))">
  <div class="container consult">
    <div class="form-card">
      <h2>Konsultasi Cepat</h2>
      <p class="sub">Masukkan budget & fokus pemakaian — kami berikan rekomendasi awal.</p>
      <form id="consultForm">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:var(--sp-3);margin-top:var(--sp-3)">
          <div>
            <label for="budget" class="sub">Budget (Rp)</label>
            <input class="input" id="budget" type="number" placeholder="5000000"/>
          </div>
          <div>
            <label for="focus" class="sub">Fokus</label>
            <select id="focus" class="input">
              <option value="gaming">Gaming</option>
              <option value="kamera">Fotografi/Videografi</option>
              <option value="kerja">Produktivitas/Desain</option>
              <option value="keluarga">Ortu & Anak</option>
            </select>
          </div>
          <div>
            <label for="brand" class="sub">Preferensi Merek (opsional)</label>
            <input class="input" id="brand" placeholder="Contoh: Samsung / Xiaomi"/>
          </div>
        </div>
        <div class="cta" style="margin-top:var(--sp-4)">
          <button class="btn btn-primary" data-ripple type="submit">Dapatkan Rekomendasi</button>
        </div>
      </form>
      <div id="consultResult" style="display:none;margin-top:var(--sp-3)"></div>
    </div>
  </div>
</section>