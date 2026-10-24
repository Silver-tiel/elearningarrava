<!-- Component Global: Retro Pixel Hover Frame & Sound Effects -->
<style>
  :root {
    --hover-frame-scale: 1;
  }

  /* Frame Bracket Pixel Art Effect */
  .hover-frame {
    position: relative;
  }

  .hover-frame::after {
    content: "";
    position: absolute;
    pointer-events: none;
    inset: calc(-18px * var(--hover-frame-scale, 1));
    border: calc(36px * var(--hover-frame-scale, 1)) solid transparent;
    border-image: url("{{ asset('assets/widget/hoverEffect.webp') }}") 36 / calc(36px * var(--hover-frame-scale, 1)) stretch;
    image-rendering: pixelated;
    opacity: 0;
    transition: inset 0.14s cubic-bezier(0.2, 0.9, 0.3, 1.25), opacity 0.08s linear;
    z-index: 25;
  }

  .hover-frame:hover::after,
  .hover-frame:focus-visible::after,
  .hover-frame.is-active::after {
    inset: calc(-8px * var(--hover-frame-scale, 1));
    opacity: 1;
  }

  @media (prefers-reduced-motion: reduce) {
    .hover-frame::after {
      inset: calc(-8px * var(--hover-frame-scale, 1));
      transition: opacity 0.1s linear;
    }
  }
</style>

<script>
(function() {
  const AUDIO_URL = "{{ asset('assets/sounds/widgets/hoverEffectSound.mp3') }}";

  let ctx = null;
  let sampleBuf = null;
  let isLoadingAudio = false;
  let lastPlay = 0;
  let isMuted = false;
  let currentVolume = 0.75; // Volume mantap dan jelas terdengar

  function getAudioCtx() {
    if (!ctx) {
      const AC = window.AudioContext || window.webkitAudioContext;
      if (AC) ctx = new AC();
    }
    return ctx;
  }

  // Preload & decode MP3 secepat mungkin saat halaman dibuka
  function loadSoundBuffer() {
    if (sampleBuf || isLoadingAudio) return;
    const c = getAudioCtx();
    if (!c) return;

    isLoadingAudio = true;
    fetch(AUDIO_URL)
      .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.arrayBuffer();
      })
      .then(arrayBuffer => c.decodeAudioData(arrayBuffer))
      .then(decoded => {
        sampleBuf = decoded;
        isLoadingAudio = false;
      })
      .catch(() => {
        isLoadingAudio = false;
      });
  }

  // Unlock AudioContext pada interaksi apa pun
  function tryUnlockAudio() {
    const c = getAudioCtx();
    if (!c) return;
    if (c.state === 'suspended') {
      c.resume().catch(() => {});
    }
  }

  // Listener untuk membuka kunci audio secepat mungkin
  ['pointerdown', 'pointermove', 'keydown', 'touchstart', 'wheel', 'scroll'].forEach(evt => {
    window.addEventListener(evt, tryUnlockAudio, { passive: true, once: (evt === 'pointerdown' || evt === 'touchstart') });
  });

  // Eksekusi audio output
  function triggerAudioOutput() {
    const c = getAudioCtx();
    if (!c || isMuted) return;

    if (sampleBuf) {
      try {
        const s = c.createBufferSource();
        const g = c.createGain();
        s.buffer = sampleBuf;
        // File MP3 bawaan peak-nya pelan (~0.12), beri penguatan agar jelas terdengar
        g.gain.value = Math.min(2.5, currentVolume * 2.8);
        s.connect(g);
        g.connect(c.destination);
        s.start(0);
        return;
      } catch (e) {}
    }

    // Fallback Synthesizer Blip Retro jika audio buffer belum siap
    try {
      const t = c.currentTime;
      const out = c.createGain();
      out.gain.setValueAtTime(0.0001, t);
      out.gain.linearRampToValueAtTime(0.4 * currentVolume, t + 0.004);
      out.gain.exponentialRampToValueAtTime(0.0001, t + 0.16);

      const lp = c.createBiquadFilter();
      lp.type = 'lowpass';
      lp.frequency.value = 12000;

      const osc = c.createOscillator();
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(8000, t);
      osc.frequency.setValueAtTime(3800, t + 0.016);
      osc.frequency.setValueAtTime(1200, t + 0.04);
      osc.connect(lp);
      lp.connect(out);

      const body = c.createOscillator();
      body.type = 'sine';
      const bg = c.createGain();
      bg.gain.value = 0.5;
      body.frequency.setValueAtTime(1200, t + 0.04);
      body.connect(bg);
      bg.connect(out);

      out.connect(c.destination);
      osc.start(t);
      osc.stop(t + 0.18);
      body.start(t + 0.04);
      body.stop(t + 0.18);
    } catch(e) {}
  }

  // Fungsi play hover dengan pengecekan state dan auto-resume
  function playHoverSound() {
    if (isMuted) return;
    const c = getAudioCtx();
    if (!c) return;

    const now = performance.now();
    if (now - lastPlay < 45) return; // Throttle 45ms agar responsif tapi tidak double-trigger
    lastPlay = now;

    if (c.state === 'suspended') {
      c.resume().then(() => {
        triggerAudioOutput();
      }).catch(() => {});
    } else {
      triggerAudioOutput();
    }
  }

  // Event Delegation Terpusat: 100% responsif, tanpa perlu loop manual atau MutationObserver
  let currentHoveredCard = null;

  document.addEventListener('pointerover', function(e) {
    const card = e.target.closest('.hover-frame, [data-hover-sound]');
    if (card && card !== currentHoveredCard) {
      currentHoveredCard = card;
      playHoverSound();
    }
  }, { passive: true });

  document.addEventListener('pointerout', function(e) {
    const card = e.target.closest('.hover-frame, [data-hover-sound]');
    if (card && (!e.relatedTarget || !card.contains(e.relatedTarget))) {
      if (currentHoveredCard === card) {
        currentHoveredCard = null;
      }
    }
  }, { passive: true });

  // Keyboard navigation focus
  document.addEventListener('focusin', function(e) {
    const card = e.target.closest('.hover-frame, [data-hover-sound]');
    if (card && card !== currentHoveredCard) {
      currentHoveredCard = card;
      if (card.matches(':focus-visible')) {
        playHoverSound();
      }
    }
  }, { passive: true });

  document.addEventListener('focusout', function(e) {
    const card = e.target.closest('.hover-frame, [data-hover-sound]');
    if (card && currentHoveredCard === card) {
      currentHoveredCard = null;
    }
  }, { passive: true });

  // Mulai inisialisasi & download buffer audio secepatnya
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadSoundBuffer);
  } else {
    loadSoundBuffer();
  }

  // Global window API
  window.ArravaHoverSound = {
    play: playHoverSound,
    setVolume: function(v) { currentVolume = Math.max(0, Math.min(1, v)); },
    mute: function(m) { isMuted = !!m; },
    toggleMute: function() { isMuted = !isMuted; return isMuted; }
  };
})();
</script>
