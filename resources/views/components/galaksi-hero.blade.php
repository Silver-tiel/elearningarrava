@props([
    'user' => null,
    'kuisLulus' => 0,
    'modulCount' => 0,
    'quizCount' => 0,
])

<div id="galaksiHeroCard"
    class="relative w-full rounded-[24px] overflow-hidden border border-[#23325B] shadow-[0_8px_24px_rgba(5,6,15,0.28)] select-none min-h-[260px] flex flex-col justify-between p-4 sm:p-6"
    style="background-color: #05060F; touch-action: pan-y;"
    data-asset-bg="{{ asset('assets/widget/cards/herosection/herosection2/BackgroundSpace.webp') }}"
    data-asset-blue-stars="{{ asset('assets/widget/cards/herosection/herosection2/blue-stars.webp') }}"
    data-asset-twinkle="{{ asset('assets/widget/cards/herosection/herosection2/near_stars_twinkle_4frames.webp') }}"
    data-asset-celestial="{{ asset('assets/widget/cards/herosection/herosection2/layer4_celestial.webp') }}"
    data-asset-planet-big="{{ asset('assets/widget/cards/herosection/herosection2/prop-planet-big.webp') }}"
    data-asset-planet-small="{{ asset('assets/widget/cards/herosection/herosection2/prop-planet-small.webp') }}"
    data-asset-asteroid-one="{{ asset('assets/widget/cards/herosection/herosection2/asteroid-1.webp') }}"
    data-asset-asteroid-two="{{ asset('assets/widget/cards/herosection/herosection2/asteroid-2.webp') }}">

    <!-- 1-3. Panggung Scene Parallax, Planet Mengorbit & Asteroid Interaktif -->
    <div id="galaksiStage" class="absolute inset-0 overflow-hidden z-10" aria-hidden="true">
        <!-- Scene 640x360 cover (anchored right on narrow screens so ringed planet remains visible) -->
        <div id="galaksiScene" class="absolute pointer-events-none" style="z-index: 1;">
            <img src="{{ asset('assets/widget/cards/herosection/herosection2/BackgroundSpace.webp') }}"
                alt="" class="absolute inset-0 w-full h-full object-fill pointer-events-none"
                style="image-rendering: pixelated; max-width: none;">

            <!-- Strip scrolling bintang biru jauh -->
            <div id="galaksiBlueStarsStrip"
                class="absolute top-0 left-0 h-full flex pointer-events-none will-change-transform"></div>

            <!-- 4-frame twinkle spritesheet @ 640x360 per frame -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <img id="galaksiTwinkleSheet"
                    src="{{ asset('assets/widget/cards/herosection/herosection2/near_stars_twinkle_4frames.webp') }}"
                    alt="" class="absolute top-0 left-0 pointer-events-none will-change-transform"
                    style="image-rendering: pixelated; max-width: none; max-height: none;">
            </div>

            <!-- Layer 4 celestial (planet bercincin) -->
            <img id="galaksiCelestial"
                src="{{ asset('assets/widget/cards/herosection/herosection2/layer4_celestial.webp') }}"
                alt="" class="absolute inset-0 w-full h-full object-fill pointer-events-none will-change-transform"
                style="image-rendering: pixelated; max-width: none;">
        </div>

        <!-- Planet besar & bulan yang mengorbit depan/belakang -->
        <img id="galaksiPlanetBig"
            src="{{ asset('assets/widget/cards/herosection/herosection2/prop-planet-big.webp') }}"
            alt="" class="absolute top-0 left-0 pointer-events-none will-change-transform"
            style="image-rendering: pixelated; max-width: none; max-height: none; z-index: 3;">
        <img id="galaksiPlanetSmall"
            src="{{ asset('assets/widget/cards/herosection/herosection2/prop-planet-small.webp') }}"
            alt="" class="absolute top-0 left-0 pointer-events-none will-change-transform"
            style="image-rendering: pixelated; max-width: none; max-height: none; z-index: 4;">

        <!-- Container 9 asteroid fisika (pegang & lempar) -->
        <div id="galaksiRocksLayer" class="absolute inset-0 pointer-events-none" style="z-index: 5;"></div>
    </div>

    <!-- 4-5. Konten Menimpa Profil, Kartu EXP & Quick Shortcuts -->
    <x-partials.hero-dashboard-overlay
        :user="$user"
        :kuis-lulus="$kuisLulus"
        :modul-count="$modulCount"
        :quiz-count="$quizCount"
        hero-key="galaksi"
        exp-card-class="bg-[#05060F]/55 backdrop-blur-md border border-sky-300/25"
        :pointer-passthrough="true"
    />
</div>

@once
<script>
(function initGalaksiHero() {
    const card = document.getElementById('galaksiHeroCard');
    const stage = document.getElementById('galaksiStage');
    const sceneEl = document.getElementById('galaksiScene');
    const blueStarsStrip = document.getElementById('galaksiBlueStarsStrip');
    const twinkleSheet = document.getElementById('galaksiTwinkleSheet');
    const celestialEl = document.getElementById('galaksiCelestial');
    const planetBigEl = document.getElementById('galaksiPlanetBig');
    const planetSmallEl = document.getElementById('galaksiPlanetSmall');
    const rocksLayer = document.getElementById('galaksiRocksLayer');

    if (!card || !stage || !sceneEl || !blueStarsStrip || !twinkleSheet || !celestialEl || !planetBigEl || !planetSmallEl || !rocksLayer) {
        return;
    }

    const assetBlueStars = card.getAttribute('data-asset-blue-stars');
    const assetAsteroid1 = card.getAttribute('data-asset-asteroid-one');
    const assetAsteroid2 = card.getAttribute('data-asset-asteroid-two');

    const clamp = (val, min, max) => Math.min(max, Math.max(min, val));
    const rand = (min, max) => min + Math.random() * (max - min);
    const ROCK_MULTS = [1.0, 1.0, 0.75, 1.25, 1.0, 0.75, 1.25, 1.0, 0.75];

    const state = {
        width: 0,
        height: 0,
        t: 0,
        lastTime: null,
        sw: 640,
        sh: 360,
        tileW: 272,
        tileCount: 0,
        k: 2,
        rocks: [],
        dragRock: null,
        dragPointerId: null,
        grabOffset: { x: 0, y: 0 },
        dragTarget: { x: 0, y: 0 },
        pointerVel: { x: 0, y: 0 },
        lastPointerPos: { x: 0, y: 0 },
        lastPointerTime: 0,
    };

    /**
     * Adapt Flutter _propScale for both compact dashboard banners and taller cards.
     */
    function computePropScale(w, h) {
        const widthScale = w < 700 ? 2.0 : (w > 1400 ? 5.0 : (w > 1000 ? 4.0 : 3.0));
        const heightCap = Math.max(1.85, h / 115);
        return Math.min(widthScale, heightCap);
    }

    function getSpeedScale(w) {
        return clamp(w / 900, 0.8, 1.8);
    }

    function createRockHitNode(rock) {
        const hit = document.createElement('div');
        hit.className = 'absolute top-0 left-0 flex items-center justify-center cursor-grab select-none';
        hit.style.left = '0px';
        hit.style.top = '0px';
        hit.style.cursor = 'grab';
        hit.style.pointerEvents = 'auto';
        hit.style.touchAction = 'none';
        hit.style.willChange = 'transform';

        const img = document.createElement('img');
        img.src = rock.asset;
        img.alt = '';
        img.draggable = false;
        img.className = 'pointer-events-none block';
        img.style.imageRendering = 'pixelated';
        img.style.maxWidth = 'none';
        img.style.maxHeight = 'none';

        hit.appendChild(img);
        rock.hitEl = hit;
        rock.imgEl = img;
        rocksLayer.appendChild(hit);

        hit.addEventListener('pointerdown', (e) => startDrag(e, rock));
    }

    function buildBlueStarTiles(tileW, sh, count) {
        if (count === state.tileCount && blueStarsStrip.children.length === count) {
            for (const child of blueStarsStrip.children) {
                child.style.width = `${tileW}px`;
                child.style.height = `${sh}px`;
            }
            return;
        }
        state.tileCount = count;
        blueStarsStrip.innerHTML = '';
        for (let i = 0; i < count; i++) {
            const tile = document.createElement('img');
            tile.src = assetBlueStars;
            tile.alt = '';
            tile.draggable = false;
            tile.className = 'shrink-0 pointer-events-none';
            tile.style.width = `${tileW}px`;
            tile.style.height = `${sh}px`;
            tile.style.imageRendering = 'pixelated';
            tile.style.maxWidth = 'none';
            tile.style.maxHeight = 'none';
            blueStarsStrip.appendChild(tile);
        }
    }

    function syncLayout() {
        const rect = stage.getBoundingClientRect();
        const w = Math.max(260, Math.round(rect.width));
        const h = Math.max(240, Math.round(rect.height));
        if (w === state.width && h === state.height && state.rocks.length > 0) return;

        state.width = w;
        state.height = h;
        state.k = computePropScale(w, h);

        // Cover 640x360 scene; anchor toward the right on narrow cards so the ringed planet stays visible.
        const sc = Math.max(w / 640, h / 360);
        const sw = 640 * sc;
        const sh = 360 * sc;
        const ax = sw > w * 1.15 ? 1.0 : 0.5;
        const sceneLeft = (w - sw) * ax;
        const sceneTop = (h - sh) * 0.5;

        state.sw = sw;
        state.sh = sh;
        state.tileW = (272 * sh) / 160;

        sceneEl.style.left = `${sceneLeft}px`;
        sceneEl.style.top = `${sceneTop}px`;
        sceneEl.style.width = `${sw}px`;
        sceneEl.style.height = `${sh}px`;

        twinkleSheet.style.width = `${sw * 4}px`;
        twinkleSheet.style.height = `${sh}px`;

        const tileCount = Math.ceil(sw / state.tileW) + 2;
        buildBlueStarTiles(state.tileW, sh, tileCount);

        const fresh = state.rocks.length === 0;
        if (fresh) {
            ROCK_MULTS.forEach((mult, idx) => {
                const isFirst = idx % 2 === 0;
                const rock = {
                    asset: isFirst ? assetAsteroid1 : assetAsteroid2,
                    w: isFirst ? 32 : 21,
                    h: isFirst ? 27 : 17,
                    mult,
                    x: 0,
                    y: 0,
                    vx: 0,
                    vy: 0,
                    ang: 0,
                    spin: 0,
                    s: 1,
                    r: 10,
                    m: 100,
                    hitSize: 32,
                    hitEl: null,
                    imgEl: null,
                };
                state.rocks.push(rock);
                createRockHitNode(rock);
            });
        }

        for (const r of state.rocks) {
            r.s = state.k * r.mult;
            r.r = Math.max(r.w, r.h) * r.s * 0.42;
            r.m = r.r * r.r;
            const spriteW = r.w * r.s;
            const spriteH = r.h * r.s;
            r.hitSize = Math.max(spriteW, spriteH, r.r * 2.3 + 12);
            r.hitEl.style.width = `${r.hitSize}px`;
            r.hitEl.style.height = `${r.hitSize}px`;
            r.imgEl.style.width = `${spriteW}px`;
            r.imgEl.style.height = `${spriteH}px`;
        }

        const scSpeed = getSpeedScale(w);
        const placed = [];
        for (const r of state.rocks) {
            if (fresh) {
                for (let attempt = 0; attempt < 40; attempt++) {
                    r.x = rand(r.r, Math.max(r.r + 1, w - r.r));
                    r.y = rand(r.r, Math.max(r.r + 1, h - r.r));
                    const ok = placed.every((o) => {
                        const dx = o.x - r.x;
                        const dy = o.y - r.y;
                        const md = o.r + r.r + 4;
                        return dx * dx + dy * dy > md * md;
                    });
                    if (ok) break;
                }
                const angle = rand(0, Math.PI * 2);
                const sp = rand(25, 60) * scSpeed;
                r.vx = Math.cos(angle) * sp;
                r.vy = Math.sin(angle) * sp;
                r.ang = rand(0, Math.PI * 2);
                r.spin = rand(-0.6, 0.6);
                placed.push(r);
            } else {
                r.x = clamp(r.x, r.r, Math.max(r.r, w - r.r));
                r.y = clamp(r.y, r.r, Math.max(r.r, h - r.r));
            }
        }
    }

    function integrateRocks(dt) {
        const minSp = 22 * getSpeedScale(state.width);
        const w = state.width;
        const h = state.height;

        for (const r of state.rocks) {
            if (r === state.dragRock) {
                r.vx = clamp((state.dragTarget.x - r.x) * 18, -700, 700);
                r.vy = clamp((state.dragTarget.y - r.y) * 18, -700, 700);
            } else {
                const damp = Math.exp(-dt * 0.35);
                r.vx *= damp;
                r.vy *= damp;
                const sp = Math.hypot(r.vx, r.vy);
                if (sp < minSp) {
                    if (sp < 1) {
                        const angle = rand(0, Math.PI * 2);
                        r.vx = Math.cos(angle) * minSp;
                        r.vy = Math.sin(angle) * minSp;
                    } else {
                        r.vx *= minSp / sp;
                        r.vy *= minSp / sp;
                    }
                } else if (sp > 700) {
                    r.vx *= 700 / sp;
                    r.vy *= 700 / sp;
                }
            }

            r.x += r.vx * dt;
            r.y += r.vy * dt;
            r.ang += r.spin * dt;
            if (Math.abs(r.spin) > 0.25) {
                r.spin *= Math.exp(-dt * 0.4);
            }

            if (r.x < r.r) {
                r.x = r.r;
                r.vx = Math.abs(r.vx) * 0.65;
            } else if (r.x > w - r.r) {
                r.x = w - r.r;
                r.vx = -Math.abs(r.vx) * 0.65;
            }

            if (r.y < r.r) {
                r.y = r.r;
                r.vy = Math.abs(r.vy) * 0.65;
            } else if (r.y > h - r.r) {
                r.y = h - r.r;
                r.vy = -Math.abs(r.vy) * 0.65;
            }
        }
    }

    function collideRocks() {
        const rocks = state.rocks;
        for (let i = 0; i < rocks.length; i++) {
            for (let j = i + 1; j < rocks.length; j++) {
                const a = rocks[i];
                const b = rocks[j];
                const dx = b.x - a.x;
                const dy = b.y - a.y;
                const md = a.r + b.r;
                const d2 = dx * dx + dy * dy;
                if (d2 >= md * md || d2 < 1e-6) continue;

                const dist = Math.sqrt(d2);
                const nx = dx / dist;
                const ny = dy / dist;
                const ia = a === state.dragRock ? 0 : 1 / a.m;
                const ib = b === state.dragRock ? 0 : 1 / b.m;
                const tot = ia + ib;
                if (tot === 0) continue;

                const overlap = md - dist;
                a.x -= (nx * overlap * ia) / tot;
                a.y -= (ny * overlap * ia) / tot;
                b.x += (nx * overlap * ib) / tot;
                b.y += (ny * overlap * ib) / tot;

                const rvx = b.vx - a.vx;
                const rvy = b.vy - a.vy;
                const rv = rvx * nx + rvy * ny;
                if (rv < 0) {
                    const restitution = 0.6;
                    const jp = (-(1 + restitution) * rv) / tot;
                    a.vx -= nx * jp * ia;
                    a.vy -= ny * jp * ia;
                    b.vx += nx * jp * ib;
                    b.vy += ny * jp * ib;

                    const rt = rvx * -ny + rvy * nx;
                    a.spin = clamp(a.spin + rt * 0.0015, -2.0, 2.0);
                    b.spin = clamp(b.spin + rt * 0.0015, -2.0, 2.0);
                }
            }
        }
    }

    function stepPhysics(dt) {
        state.t += dt;
        const substeps = 2;
        const subDt = dt / substeps;
        for (let i = 0; i < substeps; i++) {
            integrateRocks(subDt);
            collideRocks();
        }
    }

    function renderFrame() {
        const t = state.t;

        // Blue stars horizontal strip offset
        const off = (t * state.sh * 0.012) % state.tileW;
        blueStarsStrip.style.transform = `translate3d(${-off}px, 0, 0)`;

        // Near stars 4-frame twinkle spritesheet @ 3 FPS
        const frame = Math.floor(t * 3) % 4;
        twinkleSheet.style.transform = `translate3d(${-frame * state.sw}px, 0, 0)`;

        // Layer 4 celestial slow vertical bob
        const bobY = Math.sin(t * 0.5) * state.sh * 0.006;
        celestialEl.style.transform = `translate3d(0, ${bobY}px, 0)`;

        // Drifting big planet & orbiting moon (front/back depth sorting)
        const big = 43 * state.k;
        const moon = 16 * state.k;
        const narrow = state.width < 700;
        const cx = state.width * (narrow ? 0.14 : 0.22) + Math.sin(t * 0.15) * state.width * 0.02;
        const cy = state.height * 0.30 + Math.sin(t * 0.22) * state.height * 0.015;
        const a = t * 0.5;
        const orbitR = big * 0.95;
        const mx = cx + Math.cos(a) * orbitR;
        const my = cy + Math.sin(a) * orbitR * 0.38;
        const depth = 1 + Math.sin(a) * 0.14;
        const moonSize = moon * depth;

        planetBigEl.style.width = `${big}px`;
        planetBigEl.style.height = `${big}px`;
        planetBigEl.style.transform = `translate3d(${cx - big / 2}px, ${cy - big / 2}px, 0)`;
        planetBigEl.style.zIndex = '3';

        planetSmallEl.style.width = `${moonSize}px`;
        planetSmallEl.style.height = `${moonSize}px`;
        planetSmallEl.style.transform = `translate3d(${mx - moonSize / 2}px, ${my - moonSize / 2}px, 0)`;
        planetSmallEl.style.zIndex = Math.sin(a) >= 0 ? '4' : '2';

        // Rocks
        for (const r of state.rocks) {
            const left = r.x - r.hitSize / 2;
            const top = r.y - r.hitSize / 2;
            r.hitEl.style.transform = `translate3d(${left}px, ${top}px, 0)`;
            r.imgEl.style.transform = `rotate(${r.ang}rad)`;
        }
    }

    function getLocalPos(clientX, clientY) {
        const rect = stage.getBoundingClientRect();
        return {
            x: clientX - rect.left,
            y: clientY - rect.top,
        };
    }

    function startDrag(e, rock) {
        if (state.dragRock || (e.button !== undefined && e.button !== 0 && e.pointerType === 'mouse')) return;
        if (e.cancelable) e.preventDefault();

        const pos = getLocalPos(e.clientX, e.clientY);
        state.dragRock = rock;
        state.dragPointerId = e.pointerId;
        state.grabOffset = { x: rock.x - pos.x, y: rock.y - pos.y };
        state.dragTarget = { x: rock.x, y: rock.y };
        state.pointerVel = { x: 0, y: 0 };
        state.lastPointerPos = pos;
        state.lastPointerTime = e.timeStamp;

        // Bring dragged asteroid to front visually and in physics draw stack
        const idx = state.rocks.indexOf(rock);
        if (idx !== -1) {
            state.rocks.splice(idx, 1);
            state.rocks.push(rock);
            rocksLayer.appendChild(rock.hitEl);
        }

        rock.hitEl.style.cursor = 'grabbing';
        card.style.cursor = 'grabbing';
        try {
            stage.setPointerCapture(e.pointerId);
        } catch (_) {}
    }

    function moveDrag(e) {
        const r = state.dragRock;
        if (!r || e.pointerId !== state.dragPointerId) return;

        const pos = getLocalPos(e.clientX, e.clientY);
        state.dragTarget = {
            x: clamp(pos.x + state.grabOffset.x, r.r, Math.max(r.r, state.width - r.r)),
            y: clamp(pos.y + state.grabOffset.y, r.r, Math.max(r.r, state.height - r.r)),
        };

        const dtm = (e.timeStamp - state.lastPointerTime) / 1000;
        if (dtm > 0.0005) {
            const vx = (pos.x - state.lastPointerPos.x) / dtm;
            const vy = (pos.y - state.lastPointerPos.y) / dtm;
            state.pointerVel.x = state.pointerVel.x * 0.5 + vx * 0.5;
            state.pointerVel.y = state.pointerVel.y * 0.5 + vy * 0.5;
        }
        state.lastPointerPos = pos;
        state.lastPointerTime = e.timeStamp;
    }

    function endDrag(e) {
        const r = state.dragRock;
        if (!r || e.pointerId !== state.dragPointerId) return;

        const stale = (e.timeStamp - state.lastPointerTime) > 80;
        const v = stale ? { x: 0, y: 0 } : state.pointerVel;
        r.vx = clamp(v.x, -600, 600);
        r.vy = clamp(v.y, -600, 600);

        r.hitEl.style.cursor = 'grab';
        card.style.cursor = '';
        state.dragRock = null;
        state.dragPointerId = null;
        try {
            if (stage.hasPointerCapture(e.pointerId)) {
                stage.releasePointerCapture(e.pointerId);
            }
        } catch (_) {}
    }

    stage.addEventListener('pointermove', moveDrag);
    stage.addEventListener('pointerup', endDrag);
    stage.addEventListener('pointercancel', endDrag);

    if (typeof ResizeObserver !== 'undefined') {
        const ro = new ResizeObserver(() => syncLayout());
        ro.observe(stage);
    } else {
        window.addEventListener('resize', syncLayout);
    }

    function tick(now) {
        if (state.lastTime === null) {
            state.lastTime = now;
        }
        const dt = clamp((now - state.lastTime) / 1000, 0.001, 0.05);
        state.lastTime = now;

        if (state.rocks.length > 0 && !document.hidden) {
            stepPhysics(dt);
            renderFrame();
        }
        requestAnimationFrame(tick);
    }

    syncLayout();
    renderFrame();
    requestAnimationFrame(tick);
})();
</script>
@endonce

