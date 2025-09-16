<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silet Sumba - Berita, Budaya & Pariwisata Sumba</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ Storage::url($settings['site_logo_url']->value) }}" type="image/x-icon">

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

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    <div x-data="appHandler()" x-init="init()">
        <div x-ref="headerWrapper" :style="{ transform: `translateY(-${offset}px)` }"
            class="fixed top-0 left-0 w-full z-50 transition-transform duration-200">
            {{-- Header + Breaking News --}}
            <header class="bg-white dark:bg-gray-900 shadow-md">
                @include('partials.frontend-navbar-darkmode')
            </header>
            @if (request()->routeIs('home'))
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
        <main x-ref="mainContent" class="container mx-auto px-4 py-6">
            @yield('content')
        </main>
        {{-- Footer --}}
        @include('partials.frontend-footer')
        {{-- Dark Mode Toggle --}}
        <button @click="toggleDarkMode()"
            class="fixed bottom-5 left-5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 rounded-full shadow-lg z-50">
            <span x-show="!darkMode">🌞</span>
            <span x-show="darkMode">🌙</span>
        </button>
    </div>

    <!-- Chat AI Floating Button -->
    <div id="chatButton"
        class="fixed bottom-5 right-5 w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg z-50 text-2xl">
        💬
    </div>

    <!-- Chat AI Box -->
    <div id="chatBox"
        class="hidden fixed bottom-24 right-5 w-80 max-h-[450px] bg-white dark:bg-gray-800 rounded-xl shadow-lg z-50 overflow-hidden transition-all">
        <div class="bg-red-600 text-white p-3 font-bold">Chat Asisten Silet Sumba</div>
        <div id="chatMessages" class="p-3 h-72 overflow-y-auto flex flex-col gap-2 text-sm"></div>
        <div class="flex border-t border-gray-300 dark:border-gray-700">
            <input id="chatInput" type="text" placeholder="Tanya sesuatu..."
                class="flex-1 p-2 outline-none text-sm dark:bg-gray-700 dark:text-white">
            <button id="chatSend" class="bg-red-600 text-white px-4">Kirim</button>
        </div>
    </div>

    <script>
        function appHandler() {
            return {
                // --- Scroll Header ---
                lastScroll: 0,
                offset: 0,

                // --- Dark Mode ---
                darkMode: localStorage.getItem('theme') === 'dark',

                init() {
                    this.updateMainMargin();
                    window.addEventListener('scroll', () => {
                        let currentScroll = window.pageYOffset;
                        let delta = currentScroll - this.lastScroll;
                        this.offset = Math.min(Math.max(this.offset + delta, 0), this.$refs.headerWrapper
                            .offsetHeight);
                        this.lastScroll = currentScroll;
                        this.updateMainMargin();
                    });
                    window.addEventListener('resize', () => this.updateMainMargin());

                    if (this.darkMode) document.documentElement.classList.add('dark');
                },

                updateMainMargin() {
                    this.$refs.mainContent.style.marginTop = this.$refs.headerWrapper.offsetHeight + 'px';
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    if (this.darkMode) document.documentElement.classList.add('dark');
                    else document.documentElement.classList.remove('dark');
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chatButton = document.getElementById('chatButton');
            const chatBox = document.getElementById('chatBox');
            const chatInput = document.getElementById('chatInput');
            const chatSend = document.getElementById('chatSend');
            const chatMessages = document.getElementById('chatMessages');

            let aiIntroduced = false;
            const articleTitle = @json($article->title ?? '');
            const articleURL = window.location.href;

            function addMessage(text, from) {
                const div = document.createElement('div');
                div.classList.add('flex');
                div.style.justifyContent = from === 'ai' ? 'flex-start' : 'flex-end';

                const bubble = document.createElement('div');
                bubble.textContent = text;
                bubble.className = 'p-2 rounded-lg max-w-[70%] break-words';
                bubble.style.backgroundColor = from === 'user' ? '#DCF8C6' : '#e53e3e';
                bubble.style.color = from === 'user' ? '#000' : '#fff';

                div.appendChild(bubble);
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            chatButton.addEventListener('click', () => {
                chatBox.classList.toggle('hidden');
                if (!aiIntroduced) {
                    aiIntroduced = true;
                    let greeting = "🤖 Halo! Aku SiletBot, siap bantu kamu menemukan berita terbaru 😎.";
                    if (articleTitle) {
                        greeting +=
                            ` Kamu sedang baca artikel: "${articleTitle}". Aku bisa merangkum isinya. 🎯`;
                    }
                    addMessage(greeting, 'ai');
                }
            });

            async function sendMessage(message) {
                addMessage("👤 " + message, 'user');
                chatInput.value = '';
                try {
                    const res = await fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message
                        })
                    });
                    const data = await res.json();
                    addMessage("🤖 " + data.reply, 'ai');
                } catch (err) {
                    console.error(err);
                    addMessage("⚠️ Gagal menghubungi AI.", 'ai');
                }
            }

            chatSend.addEventListener('click', () => {
                const message = chatInput.value.trim();
                if (message) sendMessage(message);
            });

            chatInput.addEventListener('keypress', e => {
                if (e.key === 'Enter') chatSend.click();
            });
        });
    </script>



</body>

</html>
