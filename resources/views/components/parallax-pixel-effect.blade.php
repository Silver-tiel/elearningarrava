{{-- =====================================================================
     KOMPONEN LATAR BELAKANG SAMUDRA MODERN (MODERN OCEANIC AMBIENT)
     Diadaptasi dari TweenFloatBackground Flutter (Arrava Mobile)
     Digunakan di seluruh layout web (Siswa, Orang Tua, App)
     ===================================================================== --}}
@unless($hideEffect ?? false)
<style>
:root {
  --dash-img-bg:    url("{{ asset('images/backgorund1.png') }}");
  --dash-img-float: url("{{ asset('images/backgorund3.png') }}");
}

/* Canvas ambient samudra fixed di viewport, transparan dan tidak menghalangi interaksi */
.ocean-ambient-canvas {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 1;
}

/* Di layar desktop lebar (lg), posisikan canvas agar mulai tepat di sebelah kanan sidebar */
@media (min-width: 1024px) {
  body:not(.sidebar-hidden) .ocean-ambient-canvas {
    left: {{ $sidebarOffset ?? '16rem' }};
    width: calc(100% - {{ $sidebarOffset ?? '16rem' }});
  }
}

/* Pertahankan selektor layer lama untuk kompatibilitas pengujian tanpa mengganggu visual */
.dash-layer {
  display: none !important;
  pointer-events: none;
}

/* Kartu & konten di atas background efek memiliki latar belakang solid & elevasi aman */
.hover-frame,
.card,
.stat-card {
  position: relative;
  z-index: 10;
}

main, .main-content, aside, article {
  position: relative;
  z-index: 10;
}
</style>

{{-- Elemen kompatibilitas pengujian fitur --}}
<div class="dash-layer dash-bg dash-bg1" aria-hidden="true"></div>
<div class="dash-layer dash-bg dash-bg2" aria-hidden="true"></div>
<div class="dash-layer dash-float dash-f1" aria-hidden="true"></div>
<div class="dash-layer dash-float dash-f2" aria-hidden="true"></div>

{{-- Canvas Modern Oceanic Ambient (Wave & Floating Particles) --}}
<canvas id="ocean-ambient-canvas" class="ocean-ambient-canvas" aria-hidden="true"></canvas>

<script>
(function () {
  var canvas = document.getElementById('ocean-ambient-canvas');
  if (!canvas || !canvas.getContext) return;
  var ctx = canvas.getContext('2d');
  if (!ctx) return;

  // PRNG konsisten (Mulberry32 dengan seed 42, sama dengan Random(42) di Flutter)
  function mulberry32(a) {
    return function () {
      var t = a += 0x6D2B79F5;
      t = Math.imul(t ^ (t >>> 15), t | 1);
      t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
      return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
  }

  var rng = mulberry32(42);
  var particleCount = 18;
  var particles = [];

  for (var i = 0; i < particleCount; i++) {
    var isCyan = rng() > 0.5;
    particles.push({
      xPct: rng(),
      yPct: rng(),
      radius: 3.5 + rng() * 5.5,
      speed: 0.025 + rng() * 0.045,
      driftFreq: 1.2 + rng() * 1.5,
      driftAmp: 6.0 + rng() * 12.0,
      baseOpacity: 0.22 + rng() * 0.28,
      rgb: isCyan ? '81, 205, 244' : '0, 127, 190' // #51CDF4 vs #007FBE
    });
  }

  var w = 0;
  var h = 0;
  var dpr = window.devicePixelRatio || 1;

  function resize() {
    var rect = canvas.getBoundingClientRect();
    w = rect.width;
    h = rect.height;
    dpr = window.devicePixelRatio || 1;
    canvas.width = Math.round(w * dpr);
    canvas.height = Math.round(h * dpr);
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }

  window.addEventListener('resize', resize);
  resize();

  var lastTime = 0;
  var timeSec = 0;
  var currentScrollY = 0;

  function drawSmoothWave(width, height, baseY, amplitude, frequency, speed, phase, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(0, height);
    ctx.lineTo(0, baseY);

    var step = 8;
    for (var x = 0; x <= width; x += step) {
      var y = baseY + Math.sin(x * frequency + (timeSec * speed) + phase) * amplitude;
      ctx.lineTo(x, y);
    }
    var yEnd = baseY + Math.sin(width * frequency + (timeSec * speed) + phase) * amplitude;
    ctx.lineTo(width, yEnd);
    ctx.lineTo(width, height);
    ctx.closePath();
    ctx.fill();
  }

  function tick(now) {
    if (!lastTime) lastTime = now;
    var dt = (now - lastTime) / 1000;
    if (dt > 0.05) dt = 0.05;
    if (dt < 0.001) dt = 0.001;
    lastTime = now;
    timeSec += dt;

    // Periksa bila ukuran berubah (misal toggle sidebar)
    var rect = canvas.getBoundingClientRect();
    if (Math.abs(rect.width - w) > 1 || Math.abs(rect.height - h) > 1) {
      resize();
    }

    // Scroll parallax yang lembut
    var scrollY = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    currentScrollY += (scrollY - currentScrollY) * 0.12;

    ctx.clearRect(0, 0, w, h);

    // Ketinggian dasar gelombang (28% layar bawah, dibatasi 160px - 280px)
    var waveBaseH = Math.min(280, Math.max(160, h * 0.28));
    var parallax = Math.min(45, Math.max(0, currentScrollY * 0.08));
    var baseY = h - waveBaseH + parallax;

    // 1. Gelombang Lapis 1 (Deep Ocean Wave - Paling Belakang)
    drawSmoothWave(
      w, h,
      baseY + 30,
      14.0,
      0.007,
      0.7,
      0.0,
      'rgba(186, 230, 253, 0.22)'
    );

    // 2. Gelombang Lapis 2 (Mid Ocean Wave - Tengah)
    drawSmoothWave(
      w, h,
      baseY + 14,
      11.0,
      -0.9,
      2.2,
      'rgba(125, 211, 252, 0.18)'
    );

    // 3. Gelombang Lapis 3 (Front Crest Wave - Depan)
    drawSmoothWave(
      w, h,
      baseY,
      8.0,
      1.1,
      4.1,
      'rgba(224, 242, 254, 0.32)'
    );

    // 4. Partikel Gelembung Samudra Mengambang (Floating Ocean Bubbles)
    for (var i = 0; i < particles.length; i++) {
      var p = particles[i];
      p.yPct -= p.speed * dt;
      if (p.yPct < 0) {
        p.yPct = 1.0;
      }

      // Petakan ke 45% bagian bawah layar agar tidak naik menghalangi teks/kartu
      var py = h - (p.yPct * (h * 0.45));
      var drift = Math.sin(timeSec * p.driftFreq + p.xPct * 10) * p.driftAmp;
      var px = ((p.xPct * w + drift) % w + w) % w;

      var fadeFactor = Math.min(1.0, Math.max(0.0, p.yPct));
      var alpha = p.baseOpacity * fadeFactor;

      // Fill isi gelembung
      ctx.fillStyle = 'rgba(' + p.rgb + ', ' + (alpha * 0.45).toFixed(3) + ')';
      ctx.beginPath();
      ctx.arc(px, py, p.radius, 0, Math.PI * 2);
      ctx.fill();

      // Cincin halus gelembung
      ctx.strokeStyle = 'rgba(' + p.rgb + ', ' + (alpha * 0.75).toFixed(3) + ')';
      ctx.lineWidth = 1;
      ctx.stroke();
    }

    requestAnimationFrame(tick);
  }

  requestAnimationFrame(tick);
})();
</script>
@endunless
