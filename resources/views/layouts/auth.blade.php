<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arrava')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .auth-label {
            display: block;
            margin-bottom: 5px;
            color: #102B69;
            font-size: 11px;
            font-weight: 600;
        }

        .auth-field {
            display: block;
            width: 100%;
            height: 36px;
            border: 1px solid #DCE7F7;
            border-radius: 7px;
            background-color: rgba(255, 255, 255, 0.85);
            padding: 0 12px;
            color: #102B69;
            font-size: 11px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .auth-field::placeholder {
            color: #91A8CC;
        }

        .auth-field:focus {
            border-color: #3F82F6;
            box-shadow: 0 0 0 2px rgba(63, 130, 246, 0.10);
        }

        .auth-field:disabled {
            background-color: #E8F0FE;
        }

        .auth-submit {
            background: linear-gradient(90deg, #0875F9, #0875F9);
            box-shadow: 0 3px 8px rgba(8, 117, 249, 0.15);
        }

        .auth-submit:hover {
            background: linear-gradient(90deg, #0867DF, #075FE0);
        }

        @media (min-width: 1024px) {
            .auth-register-card {
                padding-top: 22px;
                padding-bottom: 22px;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#F1F7FD] font-sans text-[#102B69] antialiased">

    <main class="min-h-screen p-0 sm:p-4 lg:p-6">

        <div class="relative mx-auto flex min-h-screen w-full max-w-[1480px] flex-col overflow-hidden rounded-none border border-[#D8E7F8] bg-[#F8FBFE] shadow-[0_12px_40px_rgba(38,92,160,0.08)] sm:min-h-[700px] sm:rounded-[12px]">

            {{-- Background decoration --}}
            <div class="pointer-events-none absolute -left-[100px] top-[27%] h-[260px] w-[260px] rounded-full bg-[#E1EEFF] opacity-80"></div>

            <div class="pointer-events-none absolute -right-[100px] top-[10%] h-[250px] w-[250px] rounded-full bg-[#E3F0FF] opacity-80"></div>

            <div class="pointer-events-none absolute -bottom-[180px] left-[2%] h-[420px] w-[420px] rounded-full bg-[#E7F2FF] opacity-80"></div>

            <div class="pointer-events-none absolute -bottom-[150px] right-[20%] h-[360px] w-[360px] rounded-full bg-[#E4F1FF] opacity-70"></div>

            {{-- Header --}}
            <header class="relative z-10 flex items-center justify-between gap-3 px-6 py-5 sm:px-8 lg:px-10">

                {{-- Logo Arrava --}}
                <a href="{{ url('/') }}" class="inline-flex shrink-0 items-center gap-2 no-underline">

                    <svg viewBox="0 0 40 40" class="h-9 w-9" fill="none" aria-hidden="true">
                        <path d="M5 31 17.5 7.5C18.5 5.5 21.5 5.5 22.5 7.5L35 31"
                            stroke="#0875F9"
                            stroke-width="6"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <path d="M13.5 23.5 20 11.5 26.5 23.5"
                            stroke="#0C55C8"
                            stroke-width="5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <circle cx="20" cy="26.5" r="4" fill="#FFBE35" />
                    </svg>

                    <span class="text-[23px] font-extrabold tracking-[-0.7px] text-[#082765]">
                        Arrava
                    </span>

                </a>

                {{-- Login link --}}
                <div class="whitespace-nowrap text-sm text-[#647BA7] sm:text-base">
                    Sudah punya akun?
                    <a href="{{ url('/login') }}"
                        class="font-semibold text-[#006BFA] hover:text-blue-800">
                        Masuk
                    </a>
                </div>

            </header>

            {{-- Main content --}}
            <section class="relative z-10 flex flex-1 items-center justify-center px-4 py-5 sm:px-8 sm:py-7">

                <div class="auth-register-card w-full max-w-[430px] rounded-[11px] border border-white/90 bg-white/90 px-5 py-5 shadow-[0_12px_40px_rgba(45,94,155,0.08)] backdrop-blur-sm sm:px-7 sm:py-6 lg:px-8">

                    {{-- Logo and tagline --}}
                    <div class="mb-5 flex flex-col items-center text-center">

                        <a href="{{ url('/') }}"
                            class="mb-1.5 inline-flex items-center justify-center gap-2 no-underline">

                            <svg viewBox="0 0 40 40" class="h-9 w-9" fill="none" aria-hidden="true">
                                <path d="M5 31 17.5 7.5C18.5 5.5 21.5 5.5 22.5 7.5L35 31"
                                    stroke="#0875F9"
                                    stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />

                                <path d="M13.5 23.5 20 11.5 26.5 23.5"
                                    stroke="#0C55C8"
                                    stroke-width="5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />

                                <circle cx="20" cy="26.5" r="4" fill="#FFBE35" />
                            </svg>

                            <span class="text-[25px] font-extrabold tracking-[-0.7px] text-[#082765]">
                                Arrava
                            </span>

                        </a>

                        <p class="text-[10px] leading-5 text-[#536DA1] sm:text-[11px]">
                            E-Learning untuk Masa Depan yang Lebih Baik
                        </p>

                    </div>

                    {{-- Existing login/register form --}}
                    <div class="w-full">
                        @yield('auth_form')
                    </div>

                </div>

            </section>

            {{-- Decorative dots: top left --}}
            <div class="pointer-events-none absolute left-8 top-[112px] z-0 grid grid-cols-4 gap-[7px] opacity-60 sm:left-10">
                @for ($i = 0; $i < 12; $i++)
                    <span class="h-[5px] w-[5px] rounded-full bg-[#8AB9FF]"></span>
                    @endfor
            </div>

            {{-- Decorative dots: bottom right --}}
            <div class="pointer-events-none absolute bottom-8 right-8 z-0 grid grid-cols-4 gap-[7px] opacity-60">
                @for ($i = 0; $i < 12; $i++)
                    <span class="h-[5px] w-[5px] rounded-full bg-[#8AB9FF]"></span>
                    @endfor
            </div>

            {{-- Decorative books and plant --}}
            <div class="pointer-events-none absolute bottom-5 left-2 z-0 hidden items-end gap-1 opacity-90 sm:flex">

                <svg viewBox="0 0 150 125" class="w-[125px] lg:w-[155px]" fill="none" aria-hidden="true">

                    {{-- Plant pot --}}
                    <path d="M17 78H48L43 112Q32 119 22 112L17 78Z" fill="#E8EEF5" />
                    <ellipse cx="32" cy="78" rx="16" ry="5" fill="#FFFFFF" />
                    <ellipse cx="32" cy="78" rx="12" ry="3" fill="#C9D8E8" />

                    {{-- Leaves --}}
                    <path d="M31 78C13 66 8 47 14 33C27 39 36 56 31 78Z" fill="#4D9976" />
                    <path d="M32 78C29 57 39 38 52 34C56 51 46 69 32 78Z" fill="#6BAC80" />
                    <path d="M30 78C15 72 6 61 8 49C21 52 30 63 30 78Z" fill="#2F795D" />
                    <path d="M32 78C34 59 27 43 20 37" stroke="#397A5B" stroke-width="1.5" />
                    <path d="M32 78C37 57 44 45 50 40" stroke="#397A5B" stroke-width="1.5" />

                    {{-- Books --}}
                    <path d="M49 91 113 85 142 96 77 104 49 91Z" fill="#8FC4FA" />
                    <path d="M49 91 113 85 113 97 49 103V91Z" fill="#2F7EDB" />
                    <path d="M113 85 142 96 142 105 113 97V85Z" fill="#5CA4EF" />

                    <path d="M49 105 113 99 142 109 77 117 49 105Z" fill="#B4D9FF" />
                    <path d="M49 105 113 99 113 109 49 117V105Z" fill="#3986E4" />
                    <path d="M113 99 142 109 142 117 113 109V99Z" fill="#76B4F6" />

                    <path d="M53 95 109 90" stroke="#D9ECFF" stroke-width="1.5" />
                    <path d="M53 109 109 104" stroke="#D9ECFF" stroke-width="1.5" />

                </svg>

            </div>

        </div>

    </main>

    {{-- Password visibility --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-toggle-password]');

            const eyeIcon = `<svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"/><circle cx="12" cy="12" r="2.5"/></svg>`;

            const eyeOffIcon = `<svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" /><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" /><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" /><line x1="2" y1="2" x2="22" y2="22" /></svg>`;

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-toggle-password');
                    const passwordInput = document.getElementById(targetId);

                    if (passwordInput) {
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            this.innerHTML = eyeOffIcon;
                            this.setAttribute('aria-label', 'Sembunyikan kata sandi');
                        } else {
                            passwordInput.type = 'password';
                            this.innerHTML = eyeIcon;
                            this.setAttribute('aria-label', 'Tampilkan kata sandi');
                        }
                    }
                });
            });
        });
    </script>

    @include('components.hover-effects')

</body>

</html>