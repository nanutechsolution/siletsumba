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
    <!-- Tombol Chat Floating -->
    <div id="chatButton"
        style="position: fixed; bottom: 20px; right: 20px; width:60px; height:60px; 
        background:#e53e3e; color:white; border-radius:50%; 
        display:flex; align-items:center; justify-content:center; 
        cursor:pointer; z-index:9999; font-size:24px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
        💬
    </div>

    <!-- Chat Box -->
    <div id="chatBox"
        style="display:none; position:fixed; bottom:90px; right:20px; width:320px; max-height:450px; 
        background:white; border-radius:15px; box-shadow:0 8px 16px rgba(0,0,0,0.3); 
        z-index:9999; overflow:hidden; font-family:sans-serif;">
        <div style="background:#e53e3e; color:white; padding:12px; font-weight:bold; font-size:16px;">
            Chat Asisten Silet Sumba
        </div>
        <div id="chatMessages"
            style="padding:10px; height:300px; overflow-y:auto; font-size:14px; display:flex; flex-direction:column;">
        </div>
        <div style="display:flex; border-top:1px solid #ccc;">
            <input id="chatInput" type="text" placeholder="Tanya sesuatu..."
                style="flex:1; border:none; padding:10px; outline:none; font-size:14px;">
            <button id="chatSend"
                style="background:#e53e3e; color:white; border:none; padding:0 15px; cursor:pointer;">Kirim</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chatButton = document.getElementById('chatButton');
            const chatBox = document.getElementById('chatBox');
            const chatInput = document.getElementById('chatInput');
            const chatSend = document.getElementById('chatSend');
            const chatMessages = document.getElementById('chatMessages');

            const articleTitle = @json($article->title ?? '');
            const articleURL = window.location.href;
            const isHome = articleTitle === '' || window.location.pathname === '/';
            let aiIntroduced = false;

            function addMessage(text, from) {
                const div = document.createElement('div');
                div.style.display = 'flex';
                div.style.marginBottom = '8px';
                div.style.justifyContent = from === 'ai' ? 'flex-start' : 'flex-end';

                const bubble = document.createElement('div');
                bubble.textContent = text;
                bubble.style.padding = '8px 12px';
                bubble.style.borderRadius = '15px';
                bubble.style.maxWidth = '70%';
                bubble.style.backgroundColor = from === 'user' ? '#DCF8C6' : '#e53e3e'; // Hijau mirip WA
                bubble.style.color = from === 'user' ? '#000' : '#fff';
                bubble.style.wordWrap = 'break-word';
                bubble.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                bubble.style.opacity = 0;
                bubble.style.transform = 'translateY(20px)';
                bubble.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

                div.appendChild(bubble);

                // Tambahkan pesan ke bawah chat
                chatMessages.appendChild(div);

                requestAnimationFrame(() => {
                    bubble.style.opacity = 1;
                    bubble.style.transform = 'translateY(0)';
                });

                // Scroll otomatis jika user sudah dekat bagian bawah chat
                const isAtBottom = chatMessages.scrollHeight - chatMessages.scrollTop <= chatMessages.clientHeight +
                    20;
                if (isAtBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }

            // Fungsi indikator mengetik ala WA
            function showTypingIndicator() {
                const div = document.createElement('div');
                div.style.display = 'flex';
                div.style.justifyContent = 'flex-start';
                div.style.marginBottom = '8px';

                const bubble = document.createElement('div');
                bubble.style.padding = '8px 12px';
                bubble.style.borderRadius = '15px';
                bubble.style.backgroundColor = '#e53e3e';
                bubble.style.color = '#fff';
                bubble.style.fontStyle = 'italic';
                bubble.textContent = '🤖 mengetik...';

                div.appendChild(bubble);
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;

                return div;
            }
            async function siletBotReply(category = '', keyword = '') {
                const currentDomain = window.location.origin; // ambil domain sekarang
                const allowedDomains = ['https://siletsumba.com', 'http://127.0.0.1:8000'];

                if (!allowedDomains.includes(currentDomain)) {
                    return "🤖 Maaf, aku cuma bisa mencari berita di situs resmi Silet Sumba. 🔒";
                }

                const isHome = window.location.pathname === '/';
                let reply = "🤖 Halo! Aku SiletBot, siap bantu kamu menemukan berita terbaru 😎.\n";

                if (isHome) {
                    // Cari berita di homepage sesuai kategori/keyword
                    let apiURL = `${currentDomain}/api`;
                    if (category) apiURL += `/${category.toLowerCase()}`;
                    if (keyword) apiURL += `?q=${encodeURIComponent(keyword)}`;

                    try {
                        const response = await fetch(apiURL);
                        const data = await response.json();

                        if (data.length === 0) {
                            reply +=
                                "Maaf, belum ada berita yang sesuai nih. 😅 Coba keyword lain atau kategori lain ya!";
                        } else {
                            reply += `Aku temukan beberapa berita terbaru:\n`;
                            data.forEach((item, i) => {
                                reply += `${i+1}. "${item.title}" (${item.url})\n`;
                            });
                            reply += "\nKlik link artikelnya kalau mau ringkasan lengkapnya. 😉";
                        }
                    } catch (error) {
                        console.error(error);
                        reply += "Waduh, ada kendala saat ambil berita. 😓 Coba lagi sebentar ya!";
                    }
                } else {
                    // User membuka artikel
                    const articleTitle = @json($article->title ?? '');
                    const articleURL = window.location.href;

                    reply +=
                        `Ngomong-ngomong, kamu lagi lihat artikel: "${articleTitle}" (${articleURL}). Aku bisa ringkas isinya dalam 2-3 kalimat yang jelas dan menarik! 🎯`;
                }

                return reply;
            }

            chatButton.addEventListener('click', () => {
                chatBox.style.display = chatBox.style.display === 'none' ? 'block' : 'none';
                if (!aiIntroduced) {
                    aiIntroduced = true;
                    // Buat greeting dinamis
                    let greeting =
                        "🤖 Halo! Aku SiletBot, asisten resmi siletsumba.com 📰. Aku bisa bantu kamu memahami berita lokal dengan cepat dan mudah 😎.";

                    if (!isHome) {
                        // User membuka artikel
                        greeting +=
                            ` Ngomong-ngomong, ada artikel terbaru: "${articleTitle}" (${articleURL}). Aku bisa merangkum isinya dalam 2-3 kalimat yang jelas dan tetap menarik! 🎯`;
                    } else {
                        // User masih di home page
                        greeting +=
                            " Kamu bisa tanya tentang berita terbaru, kategori favorit, atau minta ringkasan artikel. Aku siap bantu! 💡";
                    }

                    addMessage(greeting, 'ai');
                }
            });

            async function sendMessage(message) {
                addMessage("👤 " + message, 'user');
                chatInput.value = '';
                const typingDiv = showTypingIndicator();
                const APP_URL = "{{ config('app.url') }}";
                const fullMessage = message +
                    "\n\n" +
                    (articleTitle ? `Konteks artikel: ${articleTitle} (${articleURL}). ` : '') +
                    "Jawab pertanyaan user dengan gaya santai, akrab, humor kalau perlu" +
                    `Jika pertanyaan tentang berita terbaru, selalu ambil referensi dari ${APP_URL}`;
                try {
                    const res = await fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: fullMessage
                        })
                    });
                    const data = await res.json();
                    chatMessages.removeChild(typingDiv);
                    addMessage("🤖 " + data.reply, 'ai');
                } catch (err) {
                    console.error(err);
                    chatMessages.removeChild(typingDiv);
                    addMessage("⚠️ Gagal menghubungi AI. Cek console.", 'ai');
                }
            }
            chatSend.addEventListener('click', () => {
                const message = chatInput.value.trim();
                if (message) sendMessage(message);
            });
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') chatSend.click();
            });
        });
    </script>
    <script>
        // selalu default light dulu
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

</body>

</html>
