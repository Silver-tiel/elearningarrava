<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'eBooks')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-white font-sans text-[#172036] antialiased">
    <main class="min-h-screen p-0 sm:p-4 lg:p-6">
        <div
            class="mx-auto grid min-h-screen w-full max-w-[1200px] overflow-hidden rounded-none bg-white shadow-[0_24px_55px_rgba(33,70,115,0.10)] sm:min-h-[700px] sm:rounded-[24px] lg:grid-cols-2">
            {{-- Form panel --}}
            <section class="flex min-w-0 flex-col px-6 py-8 sm:px-10 sm:py-10 lg:px-16 lg:py-12">
                <a href="{{ url('/') }}" class="mb-10 inline-flex w-fit items-center gap-2.5 no-underline sm:mb-12">
                    <span class="grid h-8 w-8 place-items-center rounded-lg bg-[#3F82F6] text-white">
                        <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 9.5 12 5l8 4.5-8 4.5L4 9.5Z" />
                            <path d="M7 11.2V15c2.8 2.2 7.2 2.2 10 0v-3.8" />
                            <path d="M20 10v5" />
                        </svg>
                    </span>
                    <span class="text-[19px] font-extrabold tracking-[-0.6px]">eBooks</span>
                </a>

                <div class="w-full max-w-[472px]">
                    @yield('auth_form')
                </div>
            </section>

            {{-- Illustration panel --}}
            <aside
                class="hidden items-center justify-center bg-gradient-to-br from-[#EDF5FF] via-[#E8F2FF] to-[#DFEEFF] px-10 py-12 text-center lg:flex lg:px-[54px]">
                <div class="w-full max-w-[430px]">
                    @yield('illustration')
                </div>
            </aside>
        </div>
    </main>
</body>

</html>