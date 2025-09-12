<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silet Sumba - Berita, Budaya & Pariwisata Sumba</title>
    {{-- icon --}}
    <link rel="shortcut icon" href="{{ Storage::url($settings['site_logo_url']->value) }}" type="image/x-icon">
    <meta name="description"
        content="Situs berita Silet Sumba menyajikan informasi terkini seputar Sumba, termasuk budaya, pariwisata, dan berita lokal.">
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-tribun-gray text-gray-800">
    <header class="bg-white shadow-md">
        @include('partials.frontend-navbar')
    </header>
    @if (request()->routeIs('home'))
        <!-- Breaking News Ticker -->
        <div class="bg-tribun-red text-white py-2 overflow-hidden">
            <div class="container mx-auto px-4">
                <div class="flex items-center">
                    <span class="bg-white text-tribun-red px-3 py-1 rounded font-bold mr-4 whitespace-nowrap">
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
        </div>
    @endif

    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>
    @include('partials.frontend-footer')
    @vite('resources/js/app.js')
    <script>
        // Update current time  
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('current-time').textContent = now.toLocaleDateString('id-ID', options);
        }

        updateTime();
        setInterval(updateTime, 60000);

        // Category tabs functionality
        const tabs = document.querySelectorAll('.category-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        // Simple scroll effect for article cards
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.article-card').forEach(card => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>

</html>
