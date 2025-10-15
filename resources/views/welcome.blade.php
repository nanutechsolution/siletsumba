<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Favicon --}}
    @php
    $faviconUrl =
    $settings['site_logo_url']?->getFirstMediaUrl('site_logo_url', 'thumb') ?? asset('default-favicon.png');
    @endphp

    <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/x-icon">

    @include('partials._meta')
    {{-- Dark mode script sebelum CSS --}}
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (!theme && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();

    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
    </noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1183290597740176" crossorigin="anonymous"></script>
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
            {{-- Iklan Display di bawah header --}}
            {{-- @if (request()->routeIs('home'))
            <div class="container mx-auto px-4 my-4 text-center">
                <div class="inline-block w-full md:w-3/4 lg:w-2/3">
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1183290597740176" crossorigin="anonymous"></script>
                    <!-- display_home_top -->
                    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});

                    </script>
                </div>
            </div>
            @endif --}}
        </div>
        {{-- <main x-ref="mainContent" class="container mx-auto px-4 py-6" style="padding-top: 20px;"> --}}
        {{-- <main class="container mx-auto px-4 py-6 pt-[220px]"> --}}
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
    <script>
        function appHandler() {
            return {
                // lastScroll: 0
                // , offset: 0
                // ,
                darkMode: localStorage.getItem('theme') === 'dark',

                // init() {
                //     this.headerHeight = this.$refs.headerWrapper.offsetHeight;
                //     this.$refs.mainContent.style.marginTop = this.headerHeight + 'px';

                //     window.addEventListener('scroll', () => {
                //         window.requestAnimationFrame(() => {
                //             let currentScroll = window.pageYOffset;
                //             let delta = currentScroll - this.lastScroll;
                //             this.offset = Math.min(Math.max(this.offset + delta, 0), this.headerHeight);
                //             this.lastScroll = currentScroll;

                //             // pakai transform, bukan marginTop
                //             this.$refs.headerWrapper.style.transform = `translateY(${-this.offset}px)`;
                //         });
                //     });

                //     window.addEventListener('resize', () => {
                //         this.headerHeight = this.$refs.headerWrapper.offsetHeight;
                //         this.$refs.mainContent.style.marginTop = this.headerHeight + 'px';
                //     });

                //     if (this.darkMode) document.documentElement.classList.add('dark');
                // },

                toggleDarkMode() {
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
