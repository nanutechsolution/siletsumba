<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ✅ Favicon --}}
    @php
    $faviconUrl = $settings['site_logo_url']?->getFirstMediaUrl('site_logo_url', 'thumb') ?? asset('default-favicon.png');
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" type="image/png">

    {{-- ✅ Meta --}}
    @include('partials._meta')

    {{-- 🌗 Dark mode script — inline kecil, tapi defer rendering --}}
    <script>
        (() => {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (!theme && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();

    </script>

    {{-- 💤 Font preload dan async load --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"></noscript>

    <link rel="preload" href="{{ Vite::asset('resources/js/app.js') }}" as="script">
    <link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style">

    {{-- 🎯 Load asset Vite (sudah minified + code splitting aktif) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 💸 Ads script: lazy-load agar tidak blocking render --}}
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

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    <div x-data="appHandler()">
        {{-- <div x-ref="headerWrapper" :style="{ transform: `translateY(-${offset}px)` }" class="fixed top-0 left-0 w-full z-50 transition-transform duration-200 will-change-transform"> --}}
        <div x-ref="headerWrapper" class="fixed top-0 left-0 w-full z-50 transition-transform duration-200 will-change-transform">
            {{-- Header + Breaking News --}}
            <header class="bg-white dark:bg-gray-900 shadow-md">
                @include('partials.frontend-navbar-darkmode')
            </header>
            @if (request()->routeIs('home')&& $breakingNews->isNotEmpty() )
            <div class="bg-red-600 text-white py-2 overflow-hidden">
                <div class="container mx-auto px-4 flex items-center">
                    <span class="bg-white text-red-600 px-3 py-1 rounded font-bold mr-4 whitespace-nowrap">
                        <i class="fas fa-bolt mr-1"></i>BREAKING NEWS
                    </span>
                    <div class="flex-1 overflow-hidden">
                        <div class="breaking-news whitespace-nowrap">
                            @foreach ($breakingNews as $news)
                            <span class="mx-6">
                                <a href="{{ route('articles.show', $news->slug) }}" class="hover:underline">
                                    {{ $news->title }}
                                </a>
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @php
        $hasBreakingNews = request()->routeIs('home') && $breakingNews->isNotEmpty();
        $mainPaddingTop = $hasBreakingNews ? 'pt-[220px]' : 'pt-[168px]'; // sesuaikan dengan nilai real saat tanpa breaking
        @endphp
        <main class="container mx-auto px-4 py-6 {{ $mainPaddingTop }}">

            @yield('content')
        </main>
        {{-- Footer --}}
        @include('partials.frontend-footer')
        {{-- Dark Mode Toggle --}}
        <button @click="toggleDarkMode()" class="fixed bottom-5 left-5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 rounded-full shadow-lg z-50">
            <span x-show="!darkMode">🌞</span>
            <span x-show="darkMode">🌙</span>
        </button>
    </div>
    <script defer>
        function appHandler() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark'
                , toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    if (this.darkMode) document.documentElement.classList.add('dark');
                    else document.documentElement.classList.remove('dark');
                }
            }
        }

    </script>


</body>

</html>
