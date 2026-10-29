{{-- =====================================================================
     KOMPONEN EFEK PARALLAX PIXEL RETRO & FLOATING PARTICLES
     Digunakan di seluruh layout (Siswa, Orang Tua, Admin)
     ===================================================================== --}}
@unless($hideEffect ?? false)
<style>
:root {
  --dash-img-bg:    url("{{ asset('images/backgorund1.png') }}");
  --dash-img-float: url("{{ asset('images/backgorund3.png') }}");
}

/* Layer efek fixed di viewport agar tidak melar mengikuti panjang scroll konten */
.dash-layer {
  position: fixed;
  pointer-events: none;
  will-change: transform, opacity;
  image-rendering: pixelated;
  z-index: 1;
}

/* Latar belakang: diselaraskan di bawah dengan buffer dasar agar saat naik tidak bolong */
.dash-bg {
  bottom: -80px;
  left: 0;
  right: 0;
  height: clamp(340px, 42vh, 430px);
  background-image: var(--dash-img-bg);
  background-position: center bottom;
  background-size: 360px 480px;
  background-repeat: repeat-x;
  opacity: 0.68;
}
.dash-bg2 {
  opacity: 0.42;
  background-position: calc(50% + 40px) bottom;
  background-size: 390px 520px;
}

/* Partikel gelombang mengambang: diselaraskan di bawah dengan buffer dasar */
.dash-float {
  bottom: -80px;
  left: 0;
  right: 0;
  height: clamp(340px, 42vh, 430px);
  background-image: var(--dash-img-float);
  background-position: center bottom;
  background-size: 360px 480px;
  background-repeat: repeat-x;
}
.dash-f1 {
  height: clamp(310px, 38vh, 390px);
  background-size: 330px 440px;
  opacity: 0.72;
}
.dash-f2 {
  height: clamp(340px, 42vh, 430px);
  background-size: 360px 480px;
  opacity: 1;
}

/* Di layar desktop lebar (lg), posisikan agar mulai tepat di sebelah kanan sidebar */
@media (min-width: 1024px) {
  body:not(.sidebar-hidden) .dash-bg,
  body:not(.sidebar-hidden) .dash-float {
    left: {{ $sidebarOffset ?? '16rem' }};
  }
}

/* Kartu di atas background efek memiliki latar belakang putih bersih & frosted glass */
.hover-frame {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
}
.hover-frame:hover {
  background: #ffffff;
}
</style>

<div class="dash-layer dash-bg dash-bg1"></div>
<div class="dash-layer dash-bg dash-bg2"></div>
<div class="dash-layer dash-float dash-f1"></div>
<div class="dash-layer dash-float dash-f2"></div>

<script>
(function () {
  var CONFIG = {
    bgSpeedBack:  0.20,
    bgSpeedFront: 0.40,
    bgFrontScaleX: -1.05,
    bgFrontScaleY:  1.05,
    fadeDistance: 0.70,
    dropDistance: 0.55,
    smoothing:    0.12,

    floats: [
      { selector: '.dash-f1', dur: 4200, ax: 2.8, ay: 7, ph: 0,   opacity: 0.72 },
      { selector: '.dash-f2', dur: 3000, ax: 2.4, ay: 5.5, ph: 0.5, opacity: 1.0 }
    ]
  };

  var bg1 = document.querySelector('.dash-bg1');
  var bg2 = document.querySelector('.dash-bg2');

  var floats = CONFIG.floats.map(function (f) {
    return { el: document.querySelector(f.selector),
             dur: f.dur, ax: f.ax, ay: f.ay, ph: f.ph, opacity: f.opacity };
  });

  // Easing sinus untuk gerakan mengambang halus
  function ease(t) { return -(Math.cos(Math.PI * t) - 1) / 2; }

  // Pingpong 0 -> 1 -> 0 seiring waktu
  function pingpong(ms, dur, ph) {
    var p = ((ms / dur) + ph) % 2;
    return p < 1 ? p : 2 - p;
  }

  var cur = 0;

  function tick(now) {
    var scrollY = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    cur += (scrollY - cur) * CONFIG.smoothing;

    // Saat scroll ke bawah (cur > 0), efek bergerak NAIK KE ATAS (Y bernilai negatif)
    var upBg1   = Math.min(65, cur * 0.12);
    var upBg2   = Math.min(75, cur * 0.16);
    var upFloat = Math.min(65, cur * 0.14);

    // (1) Latar belakang naik ke atas saat scroll ke bawah
    if (bg1) bg1.style.transform = 'translateY(' + (-upBg1) + 'px)';
    if (bg2) bg2.style.transform = 'translateY(' + (-upBg2) + 'px) ' +
                                  'scale(' + CONFIG.bgFrontScaleX + ',' + CONFIG.bgFrontScaleY + ')';

    // (2) Partikel mengambang halus sinus & naik ke atas saat scroll ke bawah
    floats.forEach(function (l) {
      if (!l.el) return;
      var ex = ease(pingpong(now, l.dur * 1.3, l.ph)) * 2 - 1;
      var ey = ease(pingpong(now, l.dur, 0)) * 2 - 1;
      l.el.style.transform =
        'translate(' + (ex * l.ax) + '%,' + (-ey * l.ay) + '%) ' +
        'translateY(' + (-upFloat) + 'px)';
    });

    requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
})();
</script>
@endunless
