/* =============================================================
   SCRIPT.JS - Frontend Logic (NO COMMUNITY VERSION)
   ============================================================= */

/* ===== Data HP (Mock Data) ===== */
const mockGadgets = [
  {
    id: 1, name: "Infinix Note 50 Pro", tier: "Entry Level", price: "Rp2,9 Juta",
    image: "https://global.pro.infinixmobility.com/media/wysiwyg/x6855_note50_Pro_family.png",
    highlights: ["MediaTek Helio G100", "Kamera 108MP OIS", "Layar AMOLED 6,7\" 120Hz", "Baterai 5000 mAh", "Fast charging 90W", "Stereo speaker", "NFC untuk pembayaran non-tunai", "Desain belakang kaca doff"]
  },
  {
    id: 2, name: "Poco X7 Pro", tier: "Midrange", price: "Rp4,7 Juta",
    image: "https://i02.appmifile.com/810_operator_sg/19/02/2025/5a238f09ba0e3b1b38d9965ead5d0ca6.png",
    highlights: ["Dimensity 8400 Ultra", "Kamera 64MP OIS", "Layar AMOLED 6,67\" 120Hz", "Baterai 5100 mAh", "Fast charging 80W", "Speaker stereo dengan Dolby Atmos", "Wi-Fi 6 & 5G lengkap", "Frame datar dengan finishing matte"]
  },
  {
    id: 3, name: "Xiaomi 17 Pro", tier: "Flagship", price: "Rp15,5 Juta",
    image: "https://www.ytechb.com/wp-content/uploads/2025/09/Xiaomi-17-wallpapers.webp",
    highlights: ["Snapdragon 8 Gen 5", "Kamera 50MP Wide + 50MP periscope telephoto + 50MP  ultrawide dengan Leica", "Layar LTPO AMOLED 6,3\" 120Hz HDR10+", "Baterai 6300 mAh", "Fast charging 100 + wireless 50", "IP69 tahan air & debu", "Build kaca + frame aluminium", "Xiaomi Hyper AI"]
  },
  {
    id: 4, name: "Oppo Find X8", tier: "Flagship", price: "Rp11,2 Juta",
    image: "https://www.oppo.com/content/dam/oppo/product-asset-library/find/find-x8-series/en/oppo-find-x8/main/assets/images-color-b-1-mo.png",
    highlights: ["Mediatek Dimensity 9400", "Kamera 50MP dengan Hasselblad", "Layar AMOLED 6,7\" 120Hz", "Baterai 4800 mAh", "SuperVOOC 100W", "Stereo speaker dengan Ultra Volume Mode", "ColorOS dengan fitur AI Highlight Video", "Desain premium dengan vegan leather / kaca"]
  },
  {
    id: 5, name: "Poco F7", tier: "Midrange", price: "Rp5,1 Juta",
    image: "https://i02.appmifile.com/727_operator_sg/10/06/2025/f16095537a39599578f64842ea23e4d6.png",
    highlights: ["Snapdragon 8s Gen 4", "Kamera 50MP OIS", "Layar AMOLED 6,67\" 120Hz", "Baterai 5500 mAh", "Fast charging 90W", "Touch sampling tinggi untuk gaming", "Vapor chamber besar untuk cooling", "Wi-Fi 6E & 5G siap dipakai"]
  },
  {
    id: 6, name: "Samsung A07", tier: "Entry Level", price: "Rp1,2 Juta",
    image: "https://images.samsung.com/is/image/samsung/p6pim/id/sm-a075fzghxid/gallery/id-galaxy-a07-sm-a075-sm-a075fzghxid-548603090?$Q90_1248_936_F_PNG$",
    highlights: ["MediaTek Helio G99", "Kamera 50MP", "Layar Full HD+ 6,6\" 90Hz", "Baterai 5000 mAh", "One UI Core yang ringan", "Slot microSD dedicated", "Fingerprint di samping (side-mounted)", "Body ringan cocok untuk pemakaian orang tua"]
  },
  {
    id: 7, name: "Samsung A08", tier: "Entry Level", price: "Rp1,6 Juta",
    image: "https://images.samsung.com/is/image/samsung/p6pim/id/sm-a075fzghxid/gallery/id-galaxy-a07-sm-a075-sm-a075fzghxid-548603090?$Q90_1248_936_F_PNG$",
    highlights: ["Exynos entry level terbaru", "Kamera 50MP + 2MP depth", "Layar HD+ 6,6\" 90Hz", "Baterai 5000 mAh", "USB-C dengan charging 25W", "Dukungan update software beberapa tahun", "Dual SIM + microSD", "Pilihan warna pastel untuk anak muda"]
  }
];

/* ===== DOM Elements ===== */
const grid = document.getElementById('grid');
const cats = document.getElementById('cats');
const sessionInfo = document.getElementById('sessionInfo');
const hamb = document.getElementById('hamb');
const mobile = document.getElementById('mobile');
const particles = document.getElementById('particles');
const aura = document.querySelector('.cursor-aura');
const progress = document.getElementById('progress');
const totop = document.getElementById('totop');
const consultForm = document.getElementById('consultForm');
const consultResult = document.getElementById('consultResult');
const detailModal = document.getElementById('detailModal');
const detailClose = document.getElementById('detailClose');
const detailImage = document.getElementById('detailImage');
const detailName = document.getElementById('detailName');
const detailMeta = document.getElementById('detailMeta');
const detailSpecs = document.getElementById('detailSpecs');
const topHighlight = document.getElementById('topHighlight');
const loginPageForm = document.getElementById('loginPageForm');
const loginIdentifier = document.getElementById('loginIdentifier');
const loginPassword = document.getElementById('loginPassword');
const loginSubmit = document.getElementById('loginSubmit');
const loginLink = document.getElementById('loginLink');
const toastEl = document.getElementById('toast');

const registerForm = document.getElementById('registerForm');
const regEmail = document.getElementById('regEmail');
const regUsername = document.getElementById('regUsername');
const regPassword = document.getElementById('regPassword');
const regConfirm = document.getElementById('regConfirm');
const registerSubmit = document.getElementById('registerSubmit');

// Logout Form
const logoutForm = document.getElementById('logoutForm');

/* ===== AJAX Helper (Untuk Login/Register) ===== */
async function postAction(action, data = {}) {
  const fd = new FormData();
  fd.append('action', action);
  for (const k in data) fd.append(k, data[k]);
  
  try {
    const resp = await fetch('api.php', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: fd
    });
    return await resp.json();
  } catch (err) {
    console.error(err);
    return { status: 'error', message: 'Koneksi server bermasalah.' };
  }
}

/* ===== TOAST Helper ===== */
let toastTimeout;
function showToast(message, type='success'){
  if (!toastEl){
    alert(message.replace(/<[^>]+>/g,'')); // fallback
    return;
  }
  toastEl.classList.remove('success','error');
  toastEl.classList.add(type === 'error' ? 'error' : 'success');
  toastEl.textContent = message.replace(/<[^>]+>/g,'');
  toastEl.classList.add('show');
  clearTimeout(toastTimeout);
  toastTimeout = setTimeout(() => toastEl.classList.remove('show'), 2600);
}

/* ===== Render UI Logic ===== */
function card(g){
  const el = document.createElement('article');
  el.className = 'cardx reveal';
  el.setAttribute('data-stagger','');
  el.dataset.id = g.id;
  el.innerHTML = `
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
      <div>
        <h3 style="margin:2px 0 2px">${g.name}</h3>
        <div class="badge" style="color:#9fb6ff">${g.tier} • ${g.price}</div>
      </div>
      <div class="card-thumb">
        <img src="${g.image}" alt="${g.name}">
      </div>
    </div>
    <ul style="margin:10px 0 0 18px;color:#b8c7e1;font-size:14px">
      ${g.highlights.slice(0,3).map(h=>`<li>• ${h}</li>`).join('')}
    </ul>
    <div class="cta" style="margin-top:10px">
      <a class="btn" href="?page=consult" data-page-link data-ripple>Cek Kecocokan</a>
    </div>
  `;
  return el;
}

function render(list = mockGadgets){
  if (!grid) return;
  grid.innerHTML = '';
  list.forEach(g => grid.appendChild(card(g)));
  revealWatch();
  bindTilt();
}

/* ===== Session UI ===== */
function updateSessionUI(user){
  const logoutBtn = document.getElementById('logoutBtn');
  const chip = document.getElementById('chipText');

  if (sessionInfo){
    sessionInfo.textContent = user ? 'Hi, ' + user : 'Tamu';
  }
  if (chip){
    if (user){
      chip.innerHTML = `Selamat datang, <b>@${user}</b>`;
    } else {
      chip.textContent = 'Mode Tamu — login untuk akses fitur';
    }
  }
  if (loginLink){
    loginLink.textContent = user ? 'Ganti Username' : 'Login';
  }
  if (logoutBtn){
    logoutBtn.style.display = user ? 'inline-block' : 'none';
  }
}

/* ===== Init & Event Listeners ===== */
document.addEventListener('DOMContentLoaded', () => {
  document.body.classList.add('is-loaded');
  render();
  initParticles();
  revealWatch();
  bindTilt();
  updateSessionUI(SERVER_USER);
  initAuthTabs();
});

/* ===== Scroll progress + to top ===== */
window.addEventListener('scroll', () => {
  const scrollTop = window.scrollY || document.documentElement.scrollTop;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  const percent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
  if (progress) progress.style.width = percent + '%';
  if (totop) totop.style.display = scrollTop > 400 ? 'block' : 'none';
}, { passive:true });

if (totop){
  totop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));
}

/* ===== Mobile menu ===== */
if (hamb && mobile){
  hamb.addEventListener('click', () => {
    mobile.style.display = mobile.style.display === 'block' ? 'none' : 'block';
  });
}

/* ===== PAGE TRANSITION menu ===== */
document.addEventListener('click', (e) => {
  const link = e.target.closest('a[data-page-link]');
  if (!link) return;
  const href = link.getAttribute('href') || '';
  if (!href.includes('?page=')) return;
  e.preventDefault();
  document.body.classList.add('page-fade-out');
  setTimeout(() => { window.location.href = href; }, 220);
});

/* ===== Explore Kategori button (smooth scroll) ===== */
document.addEventListener('click', (e) => {
  const btn = e.target.closest('[data-scroll-target]');
  if (!btn) return;
  const sel = btn.getAttribute('data-scroll-target');
  const target = document.querySelector(sel);
  if (target){
    e.preventDefault();
    target.scrollIntoView({behavior:'smooth'});
  }
});

/* ===== LOGIN PAGE: MASUK ===== */
if (loginPageForm){
  loginPageForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const idVal = (loginIdentifier && loginIdentifier.value || '').trim();
    const pwVal = (loginPassword && loginPassword.value || '');

    if (!idVal || !pwVal){
      showToast('Isi username/email dan password.','error');
      return;
    }
    try{
      const res = await postAction('login', {
        identifier: idVal,
        password: pwVal
      });
      if (res && res.status === 'ok'){
        updateSessionUI(res.user);
        if (loginSubmit){
          const rect = loginSubmit.getBoundingClientRect();
          confettiBurst(rect.left + rect.width/2, rect.top + window.scrollY);
        }
        showToast(`Selamat datang kembali, ${res.user}!`,'success');
        setTimeout(() => { window.location.href='?page=home'; }, 1200);
      } else {
        showToast(res.message || 'Gagal login, coba lagi.','error');
      }
    } catch(err){
      console.error(err);
      showToast('Terjadi kesalahan login, coba lagi.','error');
    }
  });
}

/* ===== REGISTER PAGE ===== */
if (registerForm){
  registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const emailVal = (regEmail && regEmail.value || '').trim();
    const userVal  = (regUsername && regUsername.value || '').trim();
    const passVal  = (regPassword && regPassword.value || '');
    const confVal  = (regConfirm && regConfirm.value || '');

    if (!emailVal || !userVal || !passVal || !confVal){
      showToast('Semua kolom wajib diisi.','error');
      return;
    }

    const pwRegex = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;
    if (!pwRegex.test(passVal)){
      showToast('Password minimal 6 karakter dan harus ada huruf & angka.','error');
      return;
    }
    if (passVal !== confVal){
      showToast('Konfirmasi password tidak sama.','error');
      return;
    }

    try{
      const res = await postAction('register', {
        email: emailVal,
        username: userVal,
        password: passVal,
        confirm: confVal
      });
      if (res && res.status === 'ok'){
        updateSessionUI(res.user);
        if (registerSubmit){
          const rect = registerSubmit.getBoundingClientRect();
          confettiBurst(rect.left + rect.width/2, rect.top + window.scrollY);
        }
        showToast(`Registrasi berhasil, selamat datang ${res.user}!`,'success');
        setTimeout(() => { window.location.href='?page=home'; }, 1300);
      } else {
        showToast(res.message || 'Registrasi gagal, coba lagi.','error');
      }
    } catch(err){
      console.error(err);
      showToast('Terjadi kesalahan registrasi, coba lagi.','error');
    }
  });
}

/* ===== Logout via AJAX ===== */
if (logoutForm){
  logoutForm.addEventListener('submit', async (ev) => {
    ev.preventDefault();
    try{
      const res = await postAction('logout');
      if (res && res.status === 'ok'){
        updateSessionUI(null);
        showToast('Logout berhasil. Sampai jumpa lagi!','success');
        setTimeout(() => { window.location.href='?page=login'; }, 1000);
      } else {
        showToast(res.message || 'Logout gagal, coba lagi.','error');
      }
    } catch(err){
      console.error(err);
      showToast('Terjadi kesalahan logout, coba lagi.','error');
    }
  });
}

/* ===== Filter kategori HP ===== */
if (cats){
  cats.addEventListener('click', (e) => {
    const c = e.target.closest('.cat');
    if (!c) return;
    const f = c.getAttribute('data-filter');
    if (!f) { render(mockGadgets); return; }
    const list = mockGadgets.filter(g => g.tier === f);
    render(list);
  });
}

/* ===== Klik card gadgets -> modal detail ===== */
if (grid){
  grid.addEventListener('click', (e) => {
    const cardEl = e.target.closest('.cardx');
    if (!cardEl) return;
    if (e.target.closest('a')) return;
    const id = Number(cardEl.dataset.id);
    const g = mockGadgets.find(item => item.id === id);
    if (g) openDetail(g);
  });
}

if (detailClose){
  detailClose.addEventListener('click', closeDetail);
}
if (detailModal){
  detailModal.addEventListener('click', (e) => {
    if (e.target === detailModal) closeDetail();
  });
}

/* ===== ESC key untuk modal ===== */
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape'){
    closeDetail();
  }
});

/* ===== Klik TOP HIGHLIGHT ===== */
if (topHighlight){
  topHighlight.addEventListener('click', (e) => {
    if (e.target.closest('a')) return;
    const gid = topHighlight.getAttribute('data-gadget-id');
    if (!gid) return;
    const targetCard = document.querySelector(`.grid .cardx[data-id="${gid}"]`);
    const latestSection = document.getElementById('latest');
    if (targetCard){
      targetCard.scrollIntoView({behavior:'smooth', block:'center'});
      targetCard.classList.add('highlight-pulse');
      setTimeout(()=> targetCard.classList.remove('highlight-pulse'), 1500);
    } else if (latestSection){
      latestSection.scrollIntoView({behavior:'smooth'});
    }
  });
}

/* ===== Reveal observer ===== */
const io = new IntersectionObserver((ents) => {
  ents.forEach(ent => {
    if (ent.isIntersecting){
      const el = ent.target;
      el.classList.add('in');
      el.querySelectorAll('[data-stagger]').forEach((child, i) => {
        child.style.transitionDelay = (i*60) + 'ms';
        child.classList.add('in');
      });
      io.unobserve(el);
    }
  });
}, { threshold:.14 });

function revealWatch(){
  document.querySelectorAll('.reveal, section').forEach(el => {
    if (!el.classList.contains('in')){
      el.classList.add('reveal');
      io.observe(el);
    }
  });
}

/* ===== Ripple effect ===== */
document.addEventListener('click', (e) => {
  const target = e.target.closest('[data-ripple], .btn, .cat, .cardx, .chip');
  if (!target) return;
  const rect = target.getBoundingClientRect();
  const ripple = document.createElement('span');
  ripple.className = 'ripple';
  const size = Math.max(rect.width, rect.height);
  ripple.style.width = ripple.style.height = size + 'px';
  ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
  ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
  target.appendChild(ripple);
  setTimeout(()=> ripple.remove(), 550);
});

/* ===== Cursor aura ===== */
document.addEventListener('pointermove', (e) => {
  if (!aura) return;
  aura.style.setProperty('--mx', e.clientX + 'px');
  aura.style.setProperty('--my', e.clientY + 'px');
});

/* ===== Consult form ===== */
if (consultForm){
  consultForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const budget = + (document.getElementById('budget').value || 0);
    const focus = document.getElementById('focus').value;
    const brand = (document.getElementById('brand').value || '').trim();

    if (!budget){
      showToast('Masukkan budget terlebih dahulu!','error');
      return;
    }

    let rekom = '';
    if (focus === 'gaming'){
      if (budget < 4000000) rekom = 'POCO C65 — Gaming hemat dengan Helio G85.';
      else if (budget < 8000000) rekom = 'Redmi Note 13 Pro — kencang, AMOLED 120Hz.';
      else rekom = 'ASUS ROG Phone 8 — performa tertinggi untuk gamer sejati.';
    } else if (focus === 'kamera'){
      rekom = budget < 7000000 ? 'Infinix Zero 30 5G — kamera 108MP, video 4K selfie.' : 'Vivo X100 Pro — kualitas kamera flagship.';
    } else if (focus === 'kerja'){
      rekom = budget < 6000000 ? 'Redmi Note 12 — layar AMOLED, cocok multitasking.' : 'Samsung Galaxy S23 FE — performa dan efisiensi terbaik.';
    } else {
      rekom = 'Samsung A15 — simpel, aman, cocok untuk keluarga.';
    }

    consultResult.style.display = 'block';
    consultResult.innerHTML = `
      <div class="cardx" style="margin-top:20px">
        <h3>Rekomendasi Awal</h3>
        <p>${brand ? "Preferensi: " + brand + "<br>" : ""}</p>
        <p><b>${rekom}</b></p>
      </div>
    `;
    consultResult.scrollIntoView({behavior:'smooth'});
  });
}

/* ===== Particles ===== */
function initParticles(){
  if (!particles) return;
  const ctx = particles.getContext('2d');
  function resize(){ particles.width = innerWidth; particles.height = innerHeight; }
  resize();
  const dots = Array.from({length:44}, () => ({
    x: Math.random()*particles.width,
    y: Math.random()*particles.height,
    r: Math.random()*1.6+0.6,
    vx: (Math.random()-.5)*0.18,
    vy: (Math.random()-.5)*0.18,
    hue: Math.random()
  }));
  function tick(){
    ctx.clearRect(0,0,particles.width,particles.height);
    for (const d of dots){
      d.x += d.vx; d.y += d.vy;
      if (d.x<0 || d.x>particles.width) d.vx *= -1;
      if (d.y<0 || d.y>particles.height) d.vy *= -1;
      ctx.beginPath(); ctx.arc(d.x, d.y, d.r, 0, Math.PI*2);
      const g = ctx.createRadialGradient(d.x,d.y,0,d.x,d.y,d.r*4);
      g.addColorStop(0, `rgba(96,165,250,${0.16+0.16*Math.sin(d.hue)})`);
      g.addColorStop(1, 'transparent');
      ctx.fillStyle = g; ctx.fill(); d.hue += 0.01;
    }
    requestAnimationFrame(tick);
  }
  tick(); addEventListener('resize', resize);
}

/* ===== Tilt micro interaction ===== */
function bindTilt(){
  document.querySelectorAll('.cardx, .cat, .chip').forEach(el => {
    el.addEventListener('mousemove', ev => {
      const r = el.getBoundingClientRect();
      const rx = ((ev.clientY - r.top)/r.height - .5) * 3.5;
      const ry = ((ev.clientX - r.left)/r.width - .5) * -3.5;
      el.style.transform = `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-2px)`;
      el.style.setProperty('--sx', ((ev.clientX - r.left)/r.width*100)+'%');
      el.style.setProperty('--sy', ((ev.clientY - r.top)/r.height*100)+'%');
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = 'translateY(0)';
    });
  });
}

/* ===== Magnetic hover untuk tombol ===== */
(function(){
  const mags = document.querySelectorAll('.btn');
  mags.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const r = el.getBoundingClientRect();
      const x = (e.clientX - r.left)/r.width - .5;
      const y = (e.clientY - r.top)/r.height - .5;
      el.style.transform = `translate(${x*8}px, ${y*8}px)`;
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = 'translate(0,0)';
    });
  });
})();

/* ===== Confetti ===== */
function confettiBurst(x, y){
  const colors = ['#60a5fa','#22d3ee','#d7b75a','#a78bfa','#34d399','#f472b6'];
  const pieces = 40;
  for (let i=0;i<pieces;i++){
    const c = document.createElement('div');
    c.className = 'confetti';
    c.style.left = (x + (Math.random()*120 - 60)) + 'px';
    c.style.top  = (y + (Math.random()*40 - 20)) + 'px';
    c.style.background = `linear-gradient(180deg, ${colors[i%colors.length]}, #ffffff)`;
    c.style.setProperty('--tx', (Math.random()*600 - 300) + 'px');
    c.style.setProperty('--rot', (Math.random()*720 - 360) + 'deg');
    document.body.appendChild(c);
    setTimeout(() => c.remove(), 1700);
  }
}

/* ===== Tab Masuk / Daftar ===== */
function initAuthTabs(){
  const tabs = document.querySelectorAll('.auth-tab');
  const panels = document.querySelectorAll('.auth-panel');
  if (!tabs.length || !panels.length) return;

  tabs.forEach(btn => {
    btn.addEventListener('click', () => {
      const mode = btn.dataset.auth;
      tabs.forEach(t => t.classList.remove('active'));
      btn.classList.add('active');

      panels.forEach(p => {
        p.classList.toggle('is-active', p.dataset.auth === mode);
      });
    });
  });
}

/* ===== Detail modal HP (VERSI FINAL - CLASS TOGGLE) ===== */
function openDetail(g){
  if (!detailModal) return;
  detailImage.src = g.image;
  detailImage.alt = g.name;
  detailName.textContent = g.name;
  detailMeta.textContent = `${g.tier} • ${g.price}`;
  detailSpecs.innerHTML = g.highlights.map(h => `<li>${h}</li>`).join('');
  
  detailModal.classList.add('is-open');
  detailModal.setAttribute('aria-hidden','false');
  
  // === INI PERBAIKANNYA ===
  // Tambahkan class CSS .modal-lock-visual ke body
  // Class ini akan mematikan transform pada body, sehingga modal fixed position bekerja sempurna
  document.body.classList.add('modal-lock-visual');
}

function closeDetail(){
  if (!detailModal) return;
  
  detailModal.classList.remove('is-open');
  detailModal.setAttribute('aria-hidden','true');
  
  // === HAPUS CLASS NYA KEMBALI ===
  // Agar efek animasi/transform body kembali normal setelah modal ditutup
  document.body.classList.remove('modal-lock-visual');
}