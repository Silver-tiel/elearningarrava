@extends('layouts.auth')

@section('title', 'Masuk - Arrava Pintar')

@section('styles')
<style>
/* =====================================================================
   VARIABEL & LAPISAN EFEK DI CARD LOGIN
   ===================================================================== */
:root {
  --img-bg:    url("{{ asset('images/backgorund1.png') }}");   /* gambar 1 = latar belakang */
  --img-float: url("{{ asset('images/backgorund3.png') }}");   /* gambar 2 = partikel mengambang */

  --ink:    #0b2a6b;   /* judul */
  --sub:    #3a5aa8;   /* teks kecil */
  --accent: #1f6bff;   /* tombol */
}

/* WADAH CARD LOGIN (adaptasi phone menjadi card login) */
.auth-phone-card {
  position: relative;
  width: 100%;
  max-width: 420px;
  min-height: 560px;
  height: 580px;
  overflow: hidden;
  background: #ffffff;
  border-radius: 24px;
  border: 1px solid rgba(255, 255, 255, 0.9);
  box-shadow: 0 16px 50px rgba(10, 30, 90, .14);
}

/* LAPISAN EFEK */
.layer {
  position: absolute;
  pointer-events: none;
  will-change: transform, opacity;
  image-rendering: pixelated;      /* gambar piksel tetap tajam */
}

/* Latar belakang (gambar 1), 2 lapisan untuk efek berlapis */
.bg  {
  inset: 0;
  background: var(--img-bg) center bottom / 100% auto no-repeat;
}
/* Ekstensi warna dasar di bawah gelombang piksel agar saat transisi naik tidak ada celah putih */
.bg::after {
  content: '';
  position: absolute;
  top: 99%;
  left: -20%;
  right: -20%;
  height: 1200px;
  background: #0e59e0;
}
.bg2 { opacity: .55; }

/* Partikel mengambang (gambar 2), 2 lapisan untuk kedalaman */
.float {
  left: -6%;
  width: 112%;
  height: 120%;                    /* TINGGI gelombang */
  bottom: -14%;                    /* POSISI gelombang */
  background: var(--img-float) center bottom / 100% 100% no-repeat;
}
.f1 { height: 100%; }

/* =====================================================================
   LAYAR LOGIN
   Saat transisi: terangkat ke atas dan memudar (diatur oleh JavaScript).
   ===================================================================== */
.login-screen {
  position: absolute;
  inset: 0;
  z-index: 5;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  padding: 34px 26px 20px;
  will-change: transform, opacity;
  overflow-y: auto;
  scrollbar-width: none;
}
.login-screen::-webkit-scrollbar { display: none; }

.login-brand {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  margin-bottom: 16px;
}
.login-screen h1 { margin: 0 0 5px; font-size: 25px; font-weight: 800; color: var(--ink); text-align: center; letter-spacing: -0.5px; }
.login-screen .lead { margin: 0 0 18px; font-size: 13px; color: var(--sub); text-align: center; line-height: 1.45; }

.field { display: block; margin-bottom: 12px; }
.field span {
  display: block;
  font-size: 12px;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 5px;
}
.input-wrap {
  position: relative;
  display: flex;
  align-items: center;
}
.field input {
  width: 100%;
  padding: 12px 14px;
  border: 1.5px solid #c9d7f5;
  border-radius: 12px;
  font: inherit;
  font-size: 13.5px;
  color: var(--ink);
  background: rgba(255, 255, 255, 0.95);
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.field input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(31, 107, 255, .18);
}
.input-wrap.has-toggle input {
  padding-right: 42px;
}
.toggle-pw {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: 0;
  padding: 4px;
  color: #92a3bb;
  cursor: pointer;
}
.toggle-pw:hover { color: var(--accent); }

.err { min-height: 18px; margin: 0 0 8px; font-size: 12px; color: #c0262d; text-align: center; font-weight: 600; }

.btn {
  width: 100%;
  border: 0;
  border-radius: 14px;
  padding: 13px;
  font: 700 15px "Poppins", system-ui, sans-serif;
  color: #fff;
  background: var(--accent);
  box-shadow: 0 8px 20px rgba(0, 20, 100, .28);
  transition: transform .15s, opacity .2s, background .15s;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}
.btn:hover { background: #1557d6; }
.btn:active   { transform: scale(.96); }   /* efek tekan */
.btn:disabled { opacity: .7; cursor: not-allowed; }

/* Efek getar saat form salah / kosong */
.shake { animation: shake .4s; }
@keyframes shake {
  20%, 60% { transform: translateX(-6px); }
  40%, 80% { transform: translateX(6px); }
}

.switch-register {
  margin-top: 16px;
  text-align: center;
  font-size: 12px;
  color: #53647d;
}
.switch-register a {
  font-weight: 700;
  color: var(--accent);
  text-decoration: none;
}
.switch-register a:hover { text-decoration: underline; }

/* =====================================================================
   HALAMAN SETELAH LOGIN (Transisi Naik)
   Awalnya tersembunyi di bawah layar (translateY(100%)),
   lalu naik saat transisi (diatur oleh JavaScript).
   ===================================================================== */
.home-panel {
  position: absolute;
  inset: 0;
  z-index: 4;
  background: #f4f7ff;
  border-radius: 24px;
  padding: 30px 24px calc(24px + env(safe-area-inset-bottom, 0px));
  box-shadow: 0 -10px 30px rgba(10, 40, 120, .2);
  transform: translateY(100%);
  will-change: transform;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.home-panel::after {
  content: '';
  position: absolute;
  top: 99%;
  left: 0;
  right: 0;
  height: 600px;
  background: #f4f7ff;
}
.grab { width: 44px; height: 5px; border-radius: 3px; background: #b9c8ee; position: absolute; top: 14px; left: 50%; transform: translateX(-50%); }
.success-icon-wrap {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #ecfdf5;
  border: 1.5px solid #a7f3d0;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 18px;
  box-shadow: 0 10px 24px rgba(16, 185, 129, 0.15);
}
.home-panel h2    { margin: 0 0 6px; font-size: 24px; font-weight: 800; color: var(--ink); text-align: center; }
.home-panel .lead { margin: 0 0 20px; font-size: 13.5px; color: var(--sub); text-align: center; max-width: 290px; line-height: 1.5; }

.success-badge {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px 18px;
  border-radius: 14px;
  background: #ffffff;
  border: 1px solid #d6e0f7;
  color: var(--sub);
  font-size: 13px;
  font-weight: 600;
  box-shadow: 0 4px 14px rgba(10, 30, 90, 0.06);
}
.spinner {
  width: 15px;
  height: 15px;
  border: 2px solid rgba(31, 107, 255, 0.25);
  border-top-color: var(--accent);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@section('auth_card')
<div class="auth-phone-card" id="phone">

  <!-- ===== LAPISAN EFEK (jangan dihapus; urutannya menentukan tumpukan) ===== -->
  <div class="layer bg bg1"></div>      <!-- latar belakang, naik pelan -->
  <div class="layer bg bg2"></div>      <!-- latar belakang, naik cepat (dicerminkan) -->
  <div class="layer float f1"></div>    <!-- partikel belakang -->
  <div class="layer float f2"></div>    <!-- partikel depan -->

  <!-- ===== LAYAR LOGIN ===== -->
  <form class="login-screen" id="loginForm" action="{{ route('login.submit') }}" method="POST" autocomplete="off" novalidate>
    @csrf

    <div class="login-brand">
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-1 no-underline">
        <svg viewBox="0 0 40 40" class="h-8 w-8" fill="none" aria-hidden="true">
          <path d="M5 31 17.5 7.5C18.5 5.5 21.5 5.5 22.5 7.5L35 31" stroke="#0875F9" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M13.5 23.5 20 11.5 26.5 23.5" stroke="#0C55C8" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
          <circle cx="20" cy="26.5" r="4" fill="#FFBE35" />
        </svg>
        <span class="text-[22px] font-extrabold tracking-[-0.7px] text-[#082765]">Arrava</span>
      </a>
      <p class="text-[10px] leading-4 text-[#536DA1]">E-Learning untuk Masa Depan yang Lebih Baik</p>
    </div>

    <h1>Selamat Datang!</h1>
    <p class="lead">Silakan masuk ke akun Anda untuk melanjutkan belajar.</p>

    <label class="field">
      <span>Email</span>
      <div class="input-wrap">
        <input id="user" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocapitalize="none" required>
      </div>
    </label>

    <label class="field">
      <span>Kata Sandi</span>
      <div class="input-wrap has-toggle">
        <input id="pass" name="password" type="password" placeholder="Masukkan kata sandi" required>
        <button type="button" class="toggle-pw" id="btnTogglePassword" aria-label="Tampilkan kata sandi">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5Z" />
            <circle cx="12" cy="12" r="2.5" />
          </svg>
        </button>
      </div>
    </label>

    <p class="err" id="err">
      @if ($errors->any())
        {{ $errors->first() }}
      @elseif (session('success'))
        <span style="color: #08764F;">{{ session('success') }}</span>
      @endif
    </p>

    <button class="btn" id="go" type="submit">
      <span id="btnText">Masuk Sekarang</span>
    </button>

    <div class="switch-register">
      Belum punya akun?
      <a href="{{ route('pendaftaran') }}">Daftar sekarang</a>
    </div>
  </form>

  <!-- ===== HALAMAN SETELAH LOGIN (Transisi Naik Menggantikan Layar Masuk) ===== -->
  <section class="home-panel" id="home" aria-hidden="true">
    <div class="grab"></div>

    <div class="success-icon-wrap">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
      </svg>
    </div>

    <h2 id="hello">Halo!</h2>
    <p class="lead" id="homeLead">Login berhasil. Mengalihkan ke dashboard...</p>

    <div class="success-badge">
      <div class="spinner"></div>
      <span>Memuat Dashboard...</span>
    </div>
  </section>

</div>
@endsection

@section('scripts')
<script>
/* =====================================================================
   JAVASCRIPT EFEK & TRANSISI NAIK SAAT MASUK
   ===================================================================== */
(function () {

  /* ------------------ PENGATURAN ------------------ */
  var CFG = {
    duration: 1400,   // lama transisi (ms)
    bgBack:   1.15,   // jarak latar belakang belakang naik (x tinggi layar agar naik sempurna)
    bgFront:  1.30,   // jarak latar belakang depan naik
    drop:     1.1,    // jarak partikel turun (x tinggi layar)

    floats: [
      // s: selector | dur: ms per naik-turun | ax/ay: jarak geser (%)
      // ph: fase awal | o: opacity dasar
      { s: '.f1', dur: 4200, ax: 5, ay: 12, ph: 0,   o: 0.55 },
      { s: '.f2', dur: 3000, ax: 4, ay: 10, ph: 0.5, o: 1 }
    ]
  };

  /* ------------------ ELEMEN ------------------ */
  var $ = function (id) { return document.getElementById(id); };
  var phone = $('phone'), login = $('loginForm'), home = $('home');
  var err = $('err'), go = $('go'), btnText = $('btnText');
  var bg1 = document.querySelector('.bg1');
  var bg2 = document.querySelector('.bg2');

  var fl = CFG.floats.map(function (f) {
    return { el: document.querySelector(f.s),
             dur: f.dur, ax: f.ax, ay: f.ay, ph: f.ph, o: f.o };
  });

  /* ------------------ FUNGSI BANTU ------------------ */
  // Easing sinus untuk gerak mengambang (inilah "tween"-nya)
  function ease(t) { return -(Math.cos(Math.PI * t) - 1) / 2; }

  // Bolak-balik 0 -> 1 -> 0 seiring waktu
  function pp(ms, d, ph) {
    var p = ((ms / d) + ph) % 2;
    return p < 1 ? p : 2 - p;
  }

  // Easing cubic untuk transisi login: pelan -> cepat -> pelan
  function io(t) {
    return t < .5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
  }

  // Batasi nilai ke rentang 0..1
  function clamp(v) { return Math.min(1, Math.max(0, v)); }

  /* ------------------ LOOP ANIMASI ------------------ */
  var s = 0;                          // progres transisi (0..1)
  var target = 0;                     // tujuan: 0 = login, 1 = sudah masuk
  var last = performance.now();

  function tick(now) {
    var dt = now - last; last = now;  // selisih waktu antar frame (ms)

    // Gerakkan s menuju target, kecepatannya sesuai CFG.duration
    if (s < target)      s = Math.min(target, s + dt / CFG.duration);
    else if (s > target) s = Math.max(target, s - dt / CFG.duration);

    var p = io(s);                    // progres yang sudah dihaluskan
    var H = phone ? phone.clientHeight : 580; // tinggi kartu

    // (1) LATAR BELAKANG: naik berlapis (Y negatif = ke atas)
    if (bg1) bg1.style.transform = 'translateY(' + (-p * H * CFG.bgBack) + 'px)';
    if (bg2) bg2.style.transform = 'translateY(' + (-p * H * CFG.bgFront) + 'px) scale(-1.2,1.2)';

    // (2) PARTIKEL: mengambang + turun + memudar
    var fade = clamp(1 - p * 1.4);    // memudar sedikit lebih cepat dari transisi
    fl.forEach(function (l) {
      if (!l.el) return;
      var ex = ease(pp(now, l.dur * 1.3, l.ph)) * 2 - 1;   // gerak kiri-kanan
      var ey = ease(pp(now, l.dur, 0)) * 2 - 1;            // gerak naik-turun
      l.el.style.transform =
        'translate(' + (ex * l.ax) + '%,' + (-ey * l.ay) + '%) ' +  // mengambang (%)
        'translateY(' + (p * H * CFG.drop) + 'px)';                 // turun (px)
      l.el.style.opacity = l.o * fade;
    });

    // (3) LAYAR LOGIN: terangkat ke atas dan memudar
    if (login) {
      login.style.transform = 'translateY(' + (-p * H * 0.8) + 'px)';
      login.style.opacity = clamp(1 - p * 1.6);
    }

    // (4) HALAMAN BARU: naik dari bawah, mulai setelah p > 0.2 (ada jeda)
    if (home) {
      var q = clamp((p - 0.2) / 0.8);
      home.style.transform = 'translateY(' + ((1 - q) * 100) + '%)';
    }

    requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);

  /* ------------------ LOGIN SUBMIT & TRANSISI ------------------ */
  if (login) {
    login.addEventListener('submit', function (e) {
      e.preventDefault();               // cegah reload halaman langsung

      var u  = $('user').value.trim();
      var pw = $('pass').value;

      // Validasi sederhana
      if (!u || !pw) {
        err.textContent = 'Email dan kata sandi wajib diisi.';
        login.classList.remove('shake');
        void login.offsetWidth;         // trik agar animasi shake bisa diulang
        login.classList.add('shake');
        return;
      }

      err.textContent = '';
      go.disabled = true;
      if (btnText) btnText.textContent = 'Memproses…';

      var tokenEl = document.querySelector('input[name="_token"]');
      var token = tokenEl ? tokenEl.value : '';

      fetch(login.getAttribute('action') || '{{ route("login.submit") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: u, password: pw })
      })
      .then(function (res) {
        return res.json().then(function (data) {
          return { ok: res.ok, status: res.status, data: data };
        });
      })
      .then(function (result) {
        if (!result.ok) {
          var msg = (result.data && result.data.message) ? result.data.message : 'Email atau password salah.';
          if (result.data && result.data.errors) {
            var firstK = Object.keys(result.data.errors)[0];
            msg = result.data.errors[firstK][0] || msg;
          }
          err.textContent = msg;
          login.classList.remove('shake');
          void login.offsetWidth;
          login.classList.add('shake');
          go.disabled = false;
          if (btnText) btnText.textContent = 'Masuk Sekarang';
          return;
        }

        // Sukses -> Jalankan transisi naik
        mulaiTransisi(result.data.name || 'Siswa', result.data.redirect || '{{ url("/siswa/dashboard") }}');
      })
      .catch(function () {
        // Fallback ke form submit biasa bila fetch offline / gagal
        login.submit();
      });
    });
  }

  // Jalankan transisi naik (panggil ini HANYA jika login berhasil)
  function mulaiTransisi(nama, redirectUrl) {
    if ($('hello')) $('hello').textContent = 'Halo, ' + nama + '!';
    if ($('homeLead')) $('homeLead').textContent = 'Login berhasil. Mengalihkan ke dashboard...';
    if (home) home.setAttribute('aria-hidden', 'false');
    if (login) login.style.pointerEvents = 'none';   // login tidak bisa diklik saat tersembunyi

    target = 1;                           // <- inilah pemicu transisi naik

    // Jalankan page-loader top bar jika ada
    if (window.PageLoader && typeof window.PageLoader.start === 'function') {
      window.PageLoader.start();
    }

    // Arahkan ke URL tujuan setelah animasi selesai
    setTimeout(function () {
      window.location.href = redirectUrl;
    }, CFG.duration + 100);
  }

  // Toggle Password Visibility
  var btnToggle = $('btnTogglePassword');
  var passInput = $('pass');
  if (btnToggle && passInput) {
    btnToggle.addEventListener('click', function () {
      if (passInput.type === 'password') {
        passInput.type = 'text';
      } else {
        passInput.type = 'password';
      }
    });
  }

})();
</script>
@endsection
