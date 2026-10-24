<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon --}}
    @php
    $faviconUrl = $settings['site_logo_url']?->getFirstMediaUrl('site_logo_url', 'thumb') ?? asset('default-favicon.png');
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" type="image/png">

    {{-- Meta --}}
    @include('partials._meta')

    {{-- Dark mode instant-load --}}
    <script>
        (() => {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (!theme && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    {{-- Font: Inter (isi) + Source Serif 4 (judul) --}}
    @php
    $fontUrl = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap';
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="{{ $fontUrl }}">
    <link rel="stylesheet" href="{{ $fontUrl }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ $fontUrl }}"></noscript>

    {{-- Preload JS/CSS utama --}}
    <link rel="modulepreload" href="{{ Vite::asset('resources/js/app.js') }}">
    <link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Ads: lazy-load supaya tidak mengganggu LCP --}}
    <script>
        window.addEventListener('load', () => {
            requestIdleCallback(() => {
                const s = document.createElement('script');
                s.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1183290597740176";
                s.async = true;
                s.crossOrigin = "anonymous";
                document.body.appendChild(s);
            });
        });
    </script>
</head>

<body class="bg-silet-paper font-sans text-stone-900 antialiased dark:bg-stone-950 dark:text-stone-100">
    <div x-data="appHandler()">

        {{-- Utility bar + masthead + menu kategori (sticky) --}}
        @include('partials.frontend-navbar-darkmode')

        {{-- Breaking news (hanya beranda) --}}
        @if (request()->routeIs('home') && $breakingNews->isNotEmpty())
        <div class="bg-silet-red text-white">
            <div class="mx-auto flex max-w-7xl items-center gap-3 px-4 py-2 text-sm">
                <span class="flex flex-shrink-0 items-center gap-1.5 rounded bg-white px-2.5 py-1 text-xs font-semibold uppercase tracking-wide text-silet-red">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8z" /></svg>
                    Breaking
                </span>
                <div class="min-w-0 flex-1 overflow-hidden">
                    <div class="breaking-news marquee whitespace-nowrap">
                        @foreach ($breakingNews as $news)
                        <a href="{{ route('articles.show', $news->slug) }}" class="mx-6 hover:underline">{{ $news->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <main class="mx-auto max-w-7xl px-4 py-6 lg:py-8">
            @yield('content')
        </main>

        @include('partials.frontend-footer')
    </div>

    <script defer>
        function appHandler() {
            return {
                darkMode: document.documentElement.classList.contains('dark'),
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.darkMode);
                }
            }
        }
    </script>
</body>
</html>
