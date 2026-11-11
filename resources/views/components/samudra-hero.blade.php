@props([
    'user' => null,
    'kuisLulus' => 0,
    'modulCount' => 0,
    'quizCount' => 0,
])

<div id="samudraHeroCard"
    class="relative w-full rounded-[24px] overflow-hidden border border-[#DCEFFF] shadow-[0_8px_24px_rgba(6,32,63,0.18)] select-none min-h-[260px] flex flex-col justify-between p-4 sm:p-6"
    style="background-color: #0c4a6e;">
    <!-- 1. Background Image Bawah Laut -->
    <img src="{{ asset('assets/widget/cards/herosection/herosection1/underwaterHeroSection.webp') }}" alt="Samudra Arrava"
        class="absolute inset-0 w-full h-full object-cover object-bottom pointer-events-none z-0"
        style="image-rendering: pixelated;">

    <!-- 2. Overlay Gradasi Cahaya Atas -->
    <div class="absolute inset-0 bg-gradient-to-b from-white/20 via-transparent to-transparent pointer-events-none z-1">
    </div>

    <!-- 3. Ikan-ikan Berenang Bebas & Gelembung Interaktif -->
    <div id="samudraAquarium" class="absolute inset-0 overflow-hidden pointer-events-none z-10">
        <!-- Gelembung Udara -->
        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>
        <div class="bubble bubble-3"></div>
        <div class="bubble bubble-4"></div>
        <div class="bubble bubble-5"></div>
        <div class="bubble bubble-6"></div>
        <div class="bubble bubble-7"></div>
    </div>

    <!-- 4-5. Konten Menimpa Profil, Kartu EXP & Quick Shortcuts -->
    <x-partials.hero-dashboard-overlay
        :user="$user"
        :kuis-lulus="$kuisLulus"
        :modul-count="$modulCount"
        :quiz-count="$quizCount"
        hero-key="samudra"
    />
</div>

<style>
    /* CSS Gelembung Udara Samudra */
    .bubble {
        position: absolute;
        bottom: -20px;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.2) 60%, rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        pointer-events: none;
        animation: bubbleRise linear infinite;
    }

    .bubble-1 {
        width: 14px;
        height: 14px;
        left: 12%;
        animation-duration: 7s;
        animation-delay: 0s;
    }

    .bubble-2 {
        width: 8px;
        height: 8px;
        left: 28%;
        animation-duration: 9s;
        animation-delay: 2s;
    }

    .bubble-3 {
        width: 16px;
        height: 16px;
        left: 45%;
        animation-duration: 6.5s;
        animation-delay: 1.5s;
    }

    .bubble-4 {
        width: 10px;
        height: 10px;
        left: 62%;
        animation-duration: 8s;
        animation-delay: 3s;
    }

    .bubble-5 {
        width: 12px;
        height: 12px;
        left: 75%;
        animation-duration: 7.2s;
        animation-delay: 0.8s;
    }

    .bubble-6 {
        width: 7px;
        height: 7px;
        left: 88%;
        animation-duration: 9.5s;
        animation-delay: 4s;
    }

    .bubble-7 {
        width: 15px;
        height: 15px;
        left: 93%;
        animation-duration: 6.8s;
        animation-delay: 2.2s;
    }

    @keyframes bubbleRise {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }

        15% {
            opacity: 0.7;
        }

        50% {
            transform: translateY(-120px) translateX(8px);
        }

        100% {
            transform: translateY(-300px) translateX(-8px);
            opacity: 0;
        }
    }

    /* Fish animation styling */
    .samudra-fish {
        position: absolute;
        pointer-events: auto;
        cursor: pointer;
        image-rendering: pixelated;
        transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1);
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
    }
</style>

<script>
    (function () {
        const hero = document.getElementById('samudraHeroCard');
        const aquarium = document.getElementById('samudraAquarium');
        if (!hero || !aquarium) return;

        const heroFishBase = '{{ rtrim(asset("assets/widget/cards/herosection/herosection1"), "/") }}';
        const fishData = [
            { src: `${heroFishBase}/fish1.webp`, size: 36, speed: 28, yRatio: 0.38 },
            { src: `${heroFishBase}/fish2.webp`, size: 32, speed: 34, yRatio: 0.52 },
            { src: `${heroFishBase}/fish3.webp`, size: 48, speed: 22, yRatio: 0.44 },
            { src: `${heroFishBase}/fish4.webp`, size: 34, speed: 32, yRatio: 0.65 },
            { src: `${heroFishBase}/fish5.webp`, size: 38, speed: 26, yRatio: 0.72 },
            { src: `${heroFishBase}/fish6.webp`, size: 42, speed: 24, yRatio: 0.48 },
            { src: `${heroFishBase}/fish7.webp`, size: 46, speed: 25, yRatio: 0.58 },
            { src: `${heroFishBase}/fish8.webp`, size: 35, speed: 30, yRatio: 0.62 },
            { src: `${heroFishBase}/fish9.webp`, size: 36, speed: 27, yRatio: 0.40 },
            { src: `${heroFishBase}/fish10.webp`, size: 38, speed: 23, yRatio: 0.54 },
            { src: `${heroFishBase}/fish11.webp`, size: 36, speed: 29, yRatio: 0.69 },
        ];

        const fishElements = [];

        fishData.forEach((data, index) => {
            const img = document.createElement('img');
            img.src = data.src;
            img.className = 'samudra-fish';
            img.style.width = data.size + 'px';
            img.style.height = 'auto';

            const dir = (index % 2 === 0) ? 1 : -1;
            const initialX = Math.random() * (aquarium.clientWidth || 600);
            const initialY = (aquarium.clientHeight || 260) * data.yRatio + (Math.random() * 20 - 10);

            const fishState = {
                el: img,
                x: initialX,
                y: initialY,
                dir: dir,
                speed: data.speed,
                baseSpeed: data.speed,
                yBase: initialY,
                phase: Math.random() * Math.PI * 2,
                fleeTimeout: null,
            };

            img.style.transform = `translate(${fishState.x}px, ${fishState.y}px) scaleX(${fishState.dir})`;
            aquarium.appendChild(img);
            fishElements.push(fishState);
        });

        let lastTime = performance.now();

        function loop(currentTime) {
            const dt = Math.min((currentTime - lastTime) / 1000, 0.1);
            lastTime = currentTime;

            const containerW = aquarium.clientWidth || 800;
            const containerH = aquarium.clientHeight || 260;

            fishElements.forEach(f => {
                // Renang horizontal
                f.x += f.dir * f.speed * dt;

                // Berbalik arah saat menabrak batas
                if (f.x > containerW - 40 && f.dir > 0) {
                    f.dir = -1;
                } else if (f.x < 10 && f.dir < 0) {
                    f.dir = 1;
                }

                // Gerak vertikal bergelombang alami (bobbing)
                f.phase += dt * 2.2;
                const bobbing = Math.sin(f.phase) * 6;
                const currentY = Math.max(70, Math.min(containerH - 50, f.yBase + bobbing));

                f.el.style.transform = `translate(${f.x}px, ${currentY}px) scaleX(${f.dir})`;
            });

            requestAnimationFrame(loop);
        }

        requestAnimationFrame(loop);

        // Efek Kaget / Kabur saat cursor mendekati ikan
        hero.addEventListener('mousemove', (e) => {
            const rect = aquarium.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            fishElements.forEach(f => {
                const dx = f.x - mouseX;
                const dy = f.y - mouseY;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < 90) {
                    // Kabur menjauhi mouse
                    f.dir = dx >= 0 ? 1 : -1;
                    f.speed = f.baseSpeed * 3;

                    clearTimeout(f.fleeTimeout);
                    f.fleeTimeout = setTimeout(() => {
                        f.speed = f.baseSpeed;
                    }, 1200);
                }
            });
        });
    })();
</script>