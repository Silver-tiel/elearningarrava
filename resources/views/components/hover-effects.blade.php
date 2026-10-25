<!-- Component Global: Retro Pixel Hover Frame & UI Sound Effects -->
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

  /* Quiz Start Button Ripple Effect */
  .btn-quiz-rip {
    position: relative;
    overflow: hidden !important;
  }

  .btn-quiz-rip .rip-effect {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.45);
    transform: scale(0);
    animation: quizRipAnim 0.55s ease-out forwards;
    pointer-events: none;
  }

  @keyframes quizRipAnim {
    to {
      transform: scale(1);
      opacity: 0;
    }
  }

  /* Shake animation when error occurs */
  .shake,
  form.shake {
    animation: formShake 0.38s cubic-bezier(0.36, 0.07, 0.19, 0.97);
  }

  @keyframes formShake {

    10%,
    90% {
      transform: translateX(-2px);
    }

    20%,
    80% {
      transform: translateX(4px);
    }

    30%,
    50%,
    70% {
      transform: translateX(-7px);
    }

    40%,
    60% {
      transform: translateX(7px);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .hover-frame::after {
      inset: calc(-8px * var(--hover-frame-scale, 1));
      transition: opacity 0.1s linear;
    }

    .btn-quiz-rip .rip-effect {
      display: none;
    }

    .shake,
    form.shake {
      animation: none;
    }
  }
</style>

<script>
  (function () {
    const HOVER_AUDIO_URL = "{{ asset('assets/sounds/widgets/hoverEffectSound.mp3') }}";
    const BUTTON_AUDIO_URL = "{{ asset('assets/sounds/widgets/buttonWorkingSound.mp3') }}";
    const ERROR_AUDIO_URL = "{{ asset('assets/sounds/widgets/errorSound.mp3') }}";
    const MENU_AUDIO_URL = "{{ asset('assets/sounds/widgets/menuClickSound.mp3') }}";
    const MENU_SAMPLE_B64 = "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VVdclVVNTEFNRTMuMTAwVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//tSxNADCfR1FE29KwFIimLFjKQIVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVX/+1LExgPJHDKMwYhqCAAANIAAAARVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVQ==";

    let ctx = null;
    let hoverSampleBuf = null;
    let buttonSampleBuf = null;
    let errorSampleBuf = null;
    let menuSampleBuf = null;

    let isLoadingHover = false;
    let isLoadingButton = false;
    let isLoadingError = false;
    let isLoadingMenu = false;

    let lastHoverPlay = 0;
    let lastErrorPlay = 0;
    let isMuted = false;
    let currentVolume = 0.75;

    function getAudioCtx() {
      if (!ctx) {
        const AC = window.AudioContext || window.webkitAudioContext;
        if (AC) ctx = new AC();
      }
      return ctx;
    }

    // Decode sample Base64 menuClickSound secara instan tanpa perlu network fetch
    function decodeMenuBase64() {
      if (menuSampleBuf) return;
      const c = getAudioCtx();
      if (!c) return;
      try {
        const bin = atob(MENU_SAMPLE_B64);
        const u = new Uint8Array(bin.length);
        for (let i = 0; i < bin.length; i++) u[i] = bin.charCodeAt(i);
        c.decodeAudioData(u.buffer.slice(0), decoded => {
          menuSampleBuf = decoded;
        }, () => {});
      } catch (e) {}
    }

    // Preload & decode aset audio ke memori
    function loadAudioBuffers() {
      const c = getAudioCtx();
      if (!c) return;

      if (!hoverSampleBuf && !isLoadingHover) {
        isLoadingHover = true;
        fetch(HOVER_AUDIO_URL)
          .then(r => { if (!r.ok) throw new Error(); return r.arrayBuffer(); })
          .then(ab => c.decodeAudioData(ab))
          .then(decoded => { hoverSampleBuf = decoded; isLoadingHover = false; })
          .catch(() => { isLoadingHover = false; });
      }

      if (!buttonSampleBuf && !isLoadingButton) {
        isLoadingButton = true;
        fetch(BUTTON_AUDIO_URL)
          .then(r => { if (!r.ok) throw new Error(); return r.arrayBuffer(); })
          .then(ab => c.decodeAudioData(ab))
          .then(decoded => { buttonSampleBuf = decoded; isLoadingButton = false; })
          .catch(() => { isLoadingButton = false; });
      }

      if (!errorSampleBuf && !isLoadingError) {
        isLoadingError = true;
        fetch(ERROR_AUDIO_URL)
          .then(r => { if (!r.ok) throw new Error(); return r.arrayBuffer(); })
          .then(ab => c.decodeAudioData(ab))
          .then(decoded => { errorSampleBuf = decoded; isLoadingError = false; })
          .catch(() => { isLoadingError = false; });
      }

      if (!menuSampleBuf && !isLoadingMenu) {
        isLoadingMenu = true;
        fetch(MENU_AUDIO_URL)
          .then(r => { if (!r.ok) throw new Error(); return r.arrayBuffer(); })
          .then(ab => c.decodeAudioData(ab))
          .then(decoded => { menuSampleBuf = decoded; isLoadingMenu = false; })
          .catch(() => {
            decodeMenuBase64();
            isLoadingMenu = false;
          });
      }
    }

    // Unlock AudioContext pada interaksi apa pun
    function tryUnlockAudio() {
      const c = getAudioCtx();
      if (!c) return;
      if (c.state === 'suspended') {
        c.resume().then(() => {
          loadAudioBuffers();
          decodeMenuBase64();
        }).catch(() => { });
      } else {
        loadAudioBuffers();
        decodeMenuBase64();
      }
    }

    ['pointerdown', 'pointermove', 'keydown', 'touchstart', 'wheel', 'scroll'].forEach(evt => {
      window.addEventListener(evt, tryUnlockAudio, { passive: true, once: (evt === 'pointerdown' || evt === 'touchstart') });
    });

    // Helper Envelope Generator untuk Synthesizer
    function tone(freq, arr, hop, t, amp, tf, tm) {
      const c = getAudioCtx();
      if (!c) return;

      const n = arr.length;
      const cCurve = new Float32Array(n);
      const dur = (n - 1) * hop;

      for (let i = 0; i < n; i++) {
        let m = 1;
        if (tf != null && i >= tf) {
          m = i >= tf + 4 ? tm : 1 + (tm - 1) * (i - tf) / 4;
        }
        cCurve[i] = (arr[i] / 1000) * amp * m;
      }
      if (n > 0) cCurve[n - 1] = 0;

      const o = c.createOscillator();
      const g = c.createGain();
      o.type = 'sine';
      o.frequency.value = freq;
      g.gain.value = 0;

      const safeT = Math.max(t, c.currentTime + 0.003);
      try {
        g.gain.setValueCurveAtTime(cCurve, safeT, dur);
        g.gain.linearRampToValueAtTime(0, safeT + dur + 0.04);
      } catch (e) {
        try {
          g.gain.setValueAtTime(0.3 * amp, safeT);
          g.gain.exponentialRampToValueAtTime(0.0001, safeT + dur);
        } catch (e2) {}
      }

      o.connect(g);
      g.connect(c.destination);
      o.start(safeT);
      o.stop(safeT + dur + 0.06);
    }

    // =========================================================================
    // 1. HOVER SOUND (Card & element hover)
    // =========================================================================
    function triggerHoverAudioOutput(pitchShift = 0) {
      const c = getAudioCtx();
      if (!c || isMuted) return;

      // Variasi pitch acak antara -1 hingga +1 dari pitch dasar yang sudah ada (default: 0 semitone -> rentang -1 s/d +1)
      const randomShift = (Math.random() * 2) - 1; // rentang -1.0 s/d +1.0
      const finalPitch = pitchShift + randomShift;
      const k = Math.pow(2, finalPitch / 12);

      if (hoverSampleBuf) {
        try {
          const s = c.createBufferSource();
          const g = c.createGain();
          s.buffer = hoverSampleBuf;
          s.playbackRate.value = k;
          g.gain.value = Math.min(2.5, currentVolume * 2.8);
          s.connect(g);
          g.connect(c.destination);
          s.start(0);
          return;
        } catch (e) { }
      }

      // Fallback Synthesizer Blip Retro
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
        osc.frequency.setValueAtTime(8000 * k, t);
        osc.frequency.setValueAtTime(3800 * k, t + 0.016);
        osc.frequency.setValueAtTime(1200 * k, t + 0.04);
        osc.connect(lp);
        lp.connect(out);

        const body = c.createOscillator();
        body.type = 'sine';
        const bg = c.createGain();
        bg.gain.value = 0.5;
        body.frequency.setValueAtTime(1200 * k, t + 0.04);
        body.connect(bg);
        bg.connect(out);

        out.connect(c.destination);
        osc.start(t);
        osc.stop(t + 0.18);
        body.start(t + 0.04);
        body.stop(t + 0.18);
      } catch (e) { }
    }

    function playHoverSound(pitchShift = 0) {
      if (isMuted) return;
      const c = getAudioCtx();
      if (!c) return;

      const now = performance.now();
      if (now - lastHoverPlay < 45) return;
      lastHoverPlay = now;

      if (c.state === 'suspended') {
        c.resume().then(() => triggerHoverAudioOutput(pitchShift)).catch(() => { });
      } else {
        triggerHoverAudioOutput(pitchShift);
      }
    }

    // =========================================================================
    // 2. QUIZ START BUTTON SOUND (Sample + Synth Rising 3-Note Chime, pitch=3)
    // =========================================================================
    const CHIME_HOP = 0.004;
    const CHIME_NOTES = [
      [782, [31, 104, 298, 445, 465, 414, 367, 344, 329, 307, 271, 223, 179, 153, 142, 138, 129, 113, 93, 75, 65, 60, 54, 48, 46, 46, 42, 38, 38, 33, 23, 19, 28, 35, 37, 34, 32, 33, 33, 32, 33, 34, 31, 25, 22, 21, 21, 21, 22, 22, 22, 20, 17, 13, 11, 12, 16, 18, 17, 15, 13, 13, 12, 11, 11, 9, 5, 2, 2, 4, 5, 5, 4, 4, 4, 5, 5, 7, 9, 9, 7, 7, 19, 34, 42, 41, 36, 32, 30, 30, 30, 26, 20, 17, 16, 18, 20, 20, 19, 15, 11, 8, 6, 3, 3, 4, 4, 5, 6, 6, 6, 6, 5, 5, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 5, 5, 5, 5, 4, 3, 2, 2, 2, 3, 3, 3, 3, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 2, 1, 1, 2, 3, 4, 3, 3, 2, 5, 11, 16, 17, 15, 14, 13, 12, 11]],
      [981, [19, 101, 151, 66, 17, 10, 8, 10, 6, 16, 23, 107, 285, 357, 316, 278, 272, 271, 266, 260, 250, 239, 227, 220, 221, 207, 149, 90, 70, 65, 47, 26, 15, 13, 25, 33, 37, 39, 38, 36, 38, 41, 42, 41, 36, 31, 26, 26, 25, 21, 15, 11, 8, 8, 15, 22, 21, 16, 12, 8, 7, 10, 9, 9, 9, 9, 8, 8, 12, 15, 17, 19, 20, 19, 19, 20, 18, 16, 15, 16, 16, 17, 17, 15, 11, 11, 11, 10, 9, 8, 6, 6, 14, 22, 23, 22, 20, 18, 16, 15, 15, 15, 15, 15, 17, 18, 14, 8, 5, 4, 2, 1, 2, 2, 3, 6, 8, 9, 9, 9, 9, 8, 8, 10, 11, 10, 10, 9, 8, 7, 7, 7, 6, 5, 4, 4, 4, 3, 2, 2, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 2, 2, 1, 0, 0, 0, 0, 0, 1]],
      [1172, [13, 61, 112, 34, 20, 7, 2, 6, 6, 13, 16, 86, 98, 23, 16, 5, 6, 5, 4, 8, 12, 10, 6, 12, 13, 24, 145, 370, 382, 300, 268, 263, 259, 248, 231, 227, 226, 206, 188, 180, 163, 134, 108, 90, 79, 67, 60, 56, 56, 56, 59, 73, 74, 63, 62, 65, 57, 41, 28, 23, 24, 23, 23, 24, 22, 28, 34, 34, 33, 32, 34, 34, 36, 41, 40, 35, 34, 32, 24, 21, 20, 16, 13, 14, 15, 17, 16, 17, 20, 19, 17, 15, 11, 8, 6, 2, 3, 6, 5, 4, 5, 6, 6, 5, 5, 6, 8, 13, 15, 14, 14, 14, 14, 12, 12, 13, 16, 17, 14, 12, 13, 14, 13, 11, 9, 9, 7, 6, 3, 2, 1, 1, 1, 1, 2, 4, 4, 5, 5, 5, 6, 5, 4, 4, 5, 5, 5, 5, 4, 3, 2, 2, 2, 3, 3, 3, 2, 2, 2, 2, 1, 1, 1, 1, 0, 1, 2, 1, 2, 2, 2]]
    ];

    function playQuizChime(pitchShift = 3, vol = 0.8) {
      if (isMuted) return;
      const c = getAudioCtx();
      if (!c) return;

      if (c.state !== 'running') {
        c.resume().then(() => playQuizChime(pitchShift, vol)).catch(() => { });
        return;
      }

      // Variasi pitch acak antara -1 hingga +1 dari pitch dasar yang sudah ada (misal: 3 semitones -> rentang 2 s/d 4)
      const randomShift = (Math.random() * 2) - 1; // rentang -1.0 s/d +1.0
      const finalPitch = pitchShift + randomShift;
      const k = Math.pow(2, finalPitch / 12);

      if (buttonSampleBuf) {
        try {
          const s = c.createBufferSource();
          const g = c.createGain();
          s.buffer = buttonSampleBuf;
          s.playbackRate.value = k;
          g.gain.value = vol * 1.5;
          s.connect(g);
          g.connect(c.destination);
          s.start(0);
          return;
        } catch (e) { }
      }

      // Fallback Synthesizer Rising 3-Note Chime
      try {
        const t = c.currentTime;
        CHIME_NOTES.forEach(([freq, arr]) => {
          tone(freq * k, arr, CHIME_HOP, t, vol);
        });
      } catch (e) { }
    }

    // =========================================================================
    // 3. ERROR SOUND (Sample + Synth Beep with Echo Tail, pitch shift = -8.5)
    // =========================================================================
    const ERROR_HOP = 0.004;
    const ERROR_TAIL_FROM = 11;
    const ERROR_ENV = [19, 114, 246, 324, 317, 423, 326, 366, 425, 344, 413, 222, 168, 154, 101, 97, 57, 48, 30, 40, 23, 44, 26, 43, 22, 45, 27, 23, 35, 16, 32, 15, 24, 18, 20, 16, 16, 11, 19, 26, 22, 29, 17, 15, 9, 21, 20, 24, 32, 31, 35, 34, 22, 25, 24, 18, 21, 10, 12, 9, 13, 9, 10, 12, 7, 9, 4, 6, 3, 5, 5, 5, 7, 8, 8, 9, 5, 7, 3, 4, 3, 5, 4, 4, 3, 3, 3, 6, 4, 6, 4, 6, 5, 3, 3, 2, 3, 3, 5, 2, 2, 1, 3, 3, 5, 2, 3, 1, 3, 2, 3, 3, 3, 2, 1, 1, 1, 3, 2, 2, 3, 2, 2, 2, 2, 3, 3, 3, 3, 2, 3, 2, 3, 2, 3, 3, 2, 2, 1, 1, 2, 2, 2, 1, 2, 1, 1, 1, 1, 1, 1];

    function playErrorSound(pitchShift = -8.5, vol = 0.85, echo = 1.0) {
      if (isMuted) return;
      const c = getAudioCtx();
      if (!c) return;

      const now = performance.now();
      if (now - lastErrorPlay < 120) return; // Throttle error beeps
      lastErrorPlay = now;

      if (c.state !== 'running') {
        c.resume().then(() => playErrorSound(pitchShift, vol, echo)).catch(() => { });
        return;
      }

      // Variasi pitch acak antara -1 hingga +1 dari pitch dasar yang sudah ada (default: -8.5 semitones -> rentang -9.5 s/d -7.5)
      const randomShift = (Math.random() * 2) - 1; // rentang -1.0 s/d +1.0
      const finalPitch = pitchShift + randomShift;
      const k = Math.pow(2, finalPitch / 12);

      // 1. Putar sample asli errorSound.mp3 jika tersedia
      if (errorSampleBuf) {
        try {
          const s = c.createBufferSource();
          const g = c.createGain();
          s.buffer = errorSampleBuf;
          s.playbackRate.value = k;
          g.gain.value = vol * 1.5;
          s.connect(g);
          g.connect(c.destination);
          s.start(0);
          return;
        } catch (e) { }
      }

      // 2. Fallback Synthesizer Error Beep murni Web Audio API
      try {
        const t = c.currentTime;
        tone(1437 * k, ERROR_ENV, ERROR_HOP, t, vol, ERROR_TAIL_FROM, echo);

        // Faint low layer under the beep
        const lo = c.createOscillator();
        const lg = c.createGain();
        lo.frequency.value = 530 * k;
        lg.gain.setValueAtTime(0.0001, t);
        lg.gain.linearRampToValueAtTime(0.07 * vol, t + 0.005);
        lg.gain.setValueAtTime(0.07 * vol, t + 0.045);
        lg.gain.linearRampToValueAtTime(0, t + 0.075);
        lo.connect(lg);
        lg.connect(c.destination);
        lo.start(t);
        lo.stop(t + 0.09);
      } catch (e) { }
    }

    // =========================================================================
    // 4. MENU / SIDEBAR BUTTON CLICK & HOVER SOUND (Web Audio Buffer + MP3 + Synth)
    // =========================================================================
    const MENU_CLICK_HOP = 0.004;
    const MENU_CLICK_TAIL_FROM = 24;
    const MENU_CLICK_GROUPS = [
      [219.0, [47,365,747,844,794,769,765,752,729,708,686,660,630,596,564,544,534,527,520,513,506,500,493,487,480,474,466,456,449,443,436,430,418,407,396,385,377,372,365,355,344,332,321,312,304,298,293,286,276,269,267,261,253,245,237,231,225,218,212,206,200,195,190,187,184,181,179,177,172,168,164,161,157,153,149,144,140,135,130,125,121,119,117,115,113,110,106,102,98,94,90,87,84,81,78,76,75,73,72,72,70,69,68,66,63,61,59,57,55,53,50,47,45,43,42,41,40,38,37,35]],
      [617.3, [44,144,110,84,58,53,51,53,50,42,34,27,22,19,15,11,9,9,9,9,9,9,10,9,8,8,8,5,12,12,8,8,7,9,12,14,16,12,11,12,11,9,9,10,7,7,8,5,4,5,5,4,5,5,3,2,4,5,3,6,4,3,4,4,4,3,3,3,4,4,4,5,6,5,5,5,3,3,3,3,2,2,1,1,1,2,2,2,1,2,2,1,2,2,2,3,2,2,2,2,2,1,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1]],
      [877.8, [28,426,784,717,662,604,542,480,419,361,307,257,214,176,144,128,122,119,117,115,114,112,110,109,107,106,104,125,172,174,140,120,141,178,174,166,154,137,127,118,113,104,99,107,98,101,101,93,95,86,79,78,55,34,41,41,44,45,51,51,40,39,43,47,52,43,22,23,23,23,27,34,46,40,36,32,35,42,45,33,31,29,25,22,21,20,19,17,18,23,23,20,20,25,27,30,29,27,22,19,15,12,11,13,10,9,9,8,8,8,6,6,9,9,8,7,7,6,4,4]],
      [1293.0, [19,106,75,62,50,42,37,29,20,16,14,9,7,6,4,3,3,3,4,3,3,3,3,3,3,3,3,7,8,7,8,9,6,6,7,5,6,5,6,5,4,5,5,4,4,4,4,3,5,4,4,3,5,2,4,3,3,3,3,4,3,3,3,2,2,4,3,2,2,1,1,2,2,1,1,1,1,2,2,1,1,1,1,1,2,2,3,2,1,2,2,2,1,1,1,1,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0]],
      [2068.1, [1,74,125,99,75,60,49,40,35,30,25,19,14,11,9,7,8,8,8,8,7,7,7,7,7,7,7,10,13,12,7,10,9,9,9,9,6,6,5,6,8,7,6,6,6,6,6,5,5,6,8,8,6,5,7,7,6,5,3,5,5,4,4,5,4,4,6,4,3,3,3,3,3,3,2,3,3,2,4,4,3,3,2,3,2,2,2,2,2,2,1,2,2,2,1,1,1,2,2,2,1,1,1,1,1,1,1,1,1,1,2,1,1,0,0,1,1,1,1,1]]
    ];

    let lastMenuPlay = 0;

    function triggerMenuAudioOutput(pitchShift = 0, vol = 0.75) {
      const c = getAudioCtx();
      if (!c || isMuted) return;

      // Variasi pitch acak antara -1 hingga +1 semitone dari pitch dasar (rentang -1.0 s/d +1.0)
      const randomShift = (Math.random() * 2) - 1;
      const finalPitch = pitchShift + randomShift;
      const k = Math.pow(2, finalPitch / 12);

      // 1. Putar Web Audio Buffer Asli dari sampel user jika sudah didecode
      if (menuSampleBuf) {
        try {
          const s = c.createBufferSource();
          const g = c.createGain();
          s.buffer = menuSampleBuf;
          s.playbackRate.value = k;
          g.gain.value = Math.min(2.5, vol * currentVolume * 2.2);
          s.connect(g);
          g.connect(c.destination);
          s.start(0);
          return;
        } catch (e) { }
      }

      // 2. Fallback Langsung via HTML5 Audio Element (jaminan suara terdengar seketika)
      try {
        const audio = new Audio(MENU_AUDIO_URL);
        audio.playbackRate = k;
        audio.volume = Math.min(1, vol * currentVolume);
        audio.play().catch(() => {});
      } catch (e) { }

      // 3. Fallback Web Audio Synthesizer Pluck + Thud Retro
      try {
        const t = c.currentTime + 0.005;
        MENU_CLICK_GROUPS.forEach(([freq, arr]) => {
          tone(freq * k, arr, MENU_CLICK_HOP, t, vol * currentVolume * 0.35, MENU_CLICK_TAIL_FROM, 1.0);
        });
      } catch (e) {}
    }

    function playMenuClick(pitchShift = 0, vol = 0.75) {
      if (isMuted) return;
      const c = getAudioCtx();
      if (!c) return;

      const now = performance.now();
      if (now - lastMenuPlay < 35) return;
      lastMenuPlay = now;

      if (c.state === 'suspended') {
        c.resume().then(() => triggerMenuAudioOutput(pitchShift, vol)).catch(() => {
          triggerMenuAudioOutput(pitchShift, vol);
        });
      } else {
        triggerMenuAudioOutput(pitchShift, vol);
      }
    }

    // Event Delegation Terpusat untuk Sidebar Menu Item (Hover & Focus)
    let currentHoveredSidebarItem = null;

    document.addEventListener('pointerover', function (e) {
      const item = e.target.closest('.sidebar-menu-item');
      if (item && item !== currentHoveredSidebarItem) {
        currentHoveredSidebarItem = item;
        playMenuClick(0, 0.75);
      }
    }, { passive: true });

    document.addEventListener('pointerout', function (e) {
      const item = e.target.closest('.sidebar-menu-item');
      if (item && (!e.relatedTarget || !item.contains(e.relatedTarget))) {
        if (currentHoveredSidebarItem === item) {
          currentHoveredSidebarItem = null;
        }
      }
    }, { passive: true });

    document.addEventListener('focusin', function (e) {
      const item = e.target.closest('.sidebar-menu-item');
      if (item && item !== currentHoveredSidebarItem) {
        currentHoveredSidebarItem = item;
        if (item.matches(':focus-visible')) {
          playMenuClick(0, 0.75);
        }
      }
    }, { passive: true });

    document.addEventListener('focusout', function (e) {
      const item = e.target.closest('.sidebar-menu-item');
      if (item && currentHoveredSidebarItem === item) {
        currentHoveredSidebarItem = null;
      }
    }, { passive: true });

    // Event Delegation Terpusat untuk Sidebar Menu Item (Click)
    document.addEventListener('click', function (e) {
      const item = e.target.closest('.sidebar-menu-item');
      if (!item) return;

      playMenuClick(0, 0.88);

      // Jeda singkat (150ms) agar efek suara klik terdengar jelas sebelum pindah halaman
      if (item.tagName === 'A' && item.href && !item.href.includes('#') && !item.dataset.navigating) {
        const currentClean = window.location.href.split('#')[0].split('?')[0];
        const targetClean = item.href.split('#')[0].split('?')[0];
        if (currentClean === targetClean) return;

        e.preventDefault();
        item.dataset.navigating = 'true';
        setTimeout(() => {
          window.location.href = item.href;
        }, 150);
      }
    });

    // Efek visual ripple saat tombol kuis diklik
    function triggerButtonRipple(btn, e) {
      if (!btn) return;
      btn.classList.add('btn-quiz-rip');
      const rect = btn.getBoundingClientRect();
      const d = Math.max(rect.width, rect.height) * 2;
      const x = (e && e.clientX ? e.clientX : rect.left + rect.width / 2) - rect.left;
      const y = (e && e.clientY ? e.clientY : rect.top + rect.height / 2) - rect.top;

      const rip = document.createElement('span');
      rip.className = 'rip-effect';
      rip.style.width = d + 'px';
      rip.style.height = d + 'px';
      rip.style.left = (x - d / 2) + 'px';
      rip.style.top = (y - d / 2) + 'px';

      btn.appendChild(rip);
      setTimeout(() => rip.remove(), 600);
    }

    // Deteksi klik pada tombol pengerjaan kuis & validasi form
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('[data-quiz-start], .btn-quiz-start');
      if (!btn) return;

      // Jika tombol form submit, periksa validitas terlebih dahulu
      if (btn.type === 'submit' && btn.form) {
        if (!btn.form.checkValidity()) {
          btn.form.reportValidity();
          playErrorSound(-8.5);

          // Tambahkan efek getar (shake) pada form
          btn.form.classList.remove('shake');
          void btn.form.offsetWidth;
          btn.form.classList.add('shake');
          return;
        }

        playQuizChime(3);
        triggerButtonRipple(btn, e);

        if (!btn.dataset.submitting) {
          e.preventDefault();
          btn.dataset.submitting = 'true';
          setTimeout(() => {
            if (btn.form.requestSubmit) {
              btn.form.requestSubmit(btn);
            } else {
              btn.form.submit();
            }
          }, 180);
        }
      } else if (btn.tagName === 'A' && btn.href && !btn.dataset.navigating) {
        playQuizChime(3);
        triggerButtonRipple(btn, e);
        e.preventDefault();
        btn.dataset.navigating = 'true';
        setTimeout(() => {
          window.location.href = btn.href;
        }, 180);
      } else {
        playQuizChime(3);
        triggerButtonRipple(btn, e);
      }
    });

    // Tangkap semua event invalid HTML5 pada input/form secara global
    document.addEventListener('invalid', function (e) {
      playErrorSound(-8.5);
      const target = e.target;
      if (target && target.form) {
        target.form.classList.remove('shake');
        void target.form.offsetWidth;
        target.form.classList.add('shake');
      }
    }, true);

    // Event Delegation Terpusat untuk Hover Card
    let currentHoveredCard = null;

    document.addEventListener('pointerover', function (e) {
      if (e.target.closest('#mainSidebar, .sidebar-menu-item')) return;
      const card = e.target.closest('.hover-frame, [data-hover-sound]');
      if (card && card !== currentHoveredCard) {
        currentHoveredCard = card;
        playHoverSound();
      }
    }, { passive: true });

    document.addEventListener('pointerout', function (e) {
      const card = e.target.closest('.hover-frame, [data-hover-sound]');
      if (card && (!e.relatedTarget || !card.contains(e.relatedTarget))) {
        if (currentHoveredCard === card) {
          currentHoveredCard = null;
        }
      }
    }, { passive: true });

    // Keyboard navigation focus
    document.addEventListener('focusin', function (e) {
      if (e.target.closest('#mainSidebar, .sidebar-menu-item')) return;
      const card = e.target.closest('.hover-frame, [data-hover-sound]');
      if (card && card !== currentHoveredCard) {
        currentHoveredCard = card;
        if (card.matches(':focus-visible')) {
          playHoverSound();
        }
      }
    }, { passive: true });

    document.addEventListener('focusout', function (e) {
      const card = e.target.closest('.hover-frame, [data-hover-sound]');
      if (card && currentHoveredCard === card) {
        currentHoveredCard = null;
      }
    }, { passive: true });

    // Otomatis bunyikan error jika halaman dimuat dengan pesan error dari backend
    @if(session('error') || session('status_error') || (isset($errors) && $errors->any()))
      let pendingInitialError = true;
    @else
      let pendingInitialError = false;
    @endif

      function checkDomForErrors() {
        if (pendingInitialError) return true;
        const errorEl = document.querySelector(
          '.bg-red-50, .bg-rose-50, [role="alert"], .alert-danger, .error-feedback, [data-error-auto], .bg-\\[\\#FFF2F2\\]'
        );
        if (errorEl) {
          pendingInitialError = true;
          return true;
        }
        return false;
      }

    function tryPlayPendingError() {
      if (!pendingInitialError) return;
      const c = getAudioCtx();
      if (!c) return;

      if (c.state === 'running') {
        pendingInitialError = false;
        playErrorSound(-8.5);
      } else {
        c.resume().then(() => {
          if (pendingInitialError) {
            pendingInitialError = false;
            playErrorSound(-8.5);
          }
        }).catch(() => { });
      }
    }

    function triggerInitialError() {
      checkDomForErrors();
      if (!pendingInitialError) return;

      // 1. Coba putar langsung via HTMLAudioElement (sering berhasil jika navigasi dari domain yang sama)
      try {
        const audio = new Audio(ERROR_AUDIO_URL);
        const randomShift = (Math.random() * 2) - 1;
        audio.playbackRate = Math.pow(2, (-8.5 + randomShift) / 12);
        audio.volume = 0.85;
        audio.play().then(() => {
          pendingInitialError = false;
        }).catch(() => {
          // Jika diblokir autoplay policy browser, tryPlayPendingError akan menyambut interaksi pertama
        });
      } catch (e) { }

      // 2. Coba via Web Audio API
      setTimeout(tryPlayPendingError, 200);

      // 3. Pasang pendengar interaksi pertama jika browser memblokir audio sampai ada interaksi
      ['pointerdown', 'keydown', 'touchstart', 'pointermove', 'focusin', 'click'].forEach(evt => {
        window.addEventListener(evt, tryPlayPendingError, { passive: true, once: true });
      });
    }

    // Mulai download buffer audio secepatnya
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => {
        loadAudioBuffers();
        decodeMenuBase64();
        triggerInitialError();
      });
    } else {
      loadAudioBuffers();
      decodeMenuBase64();
      triggerInitialError();
    }

    // Global window API
    window.ArravaHoverSound = {
      playHover: playHoverSound,
      playQuizChime: function (p = 3, v = 0.8) { playQuizChime(p, v); },
      playMenuClick: function (p = 0, v = 0.7) { playMenuClick(p, v); },
      playError: function (p = -8.5, v = 0.85) { playErrorSound(p, v); },
      playErrorSound: function (p = -8.5, v = 0.85) { playErrorSound(p, v); },
      setVolume: function (v) { currentVolume = Math.max(0, Math.min(1, v)); },
      mute: function (m) { isMuted = !!m; },
      toggleMute: function () { isMuted = !isMuted; return isMuted; }
    };
  })();
</script>