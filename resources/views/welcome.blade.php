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


    <!-- Tombol Chat Gantung -->
    <div id="chatButton"
        style="position: fixed; bottom: 20px; right: 20px; background-color: #e53e3e; color:white; 
            width:60px; height:60px; border-radius:50%; display:flex; align-items:center; 
            justify-content:center; cursor:pointer; z-index:9999; font-size:24px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
        💬
    </div>

    <!-- Chat Box -->
    <div id="chatBox"
        style="display:none; position:fixed; bottom:90px; right:20px; width:320px; max-height:450px; 
            background:white; border-radius:15px; box-shadow:0 8px 16px rgba(0,0,0,0.3); 
            z-index:9999; overflow:hidden; font-family:sans-serif;">
        <div style="background:#e53e3e; color:white; padding:12px; font-weight:bold; font-size:16px;">
            Chat Asisten Sumba
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
            // Bisa kosong jika tidak ada artikel
            const articleTitle = @json($article->title ?? '');
            const articleURL = @json($article->url ?? '');
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
                bubble.style.backgroundColor = from === 'user' ? '#edf2f7' : '#e53e3e';
                bubble.style.color = from === 'user' ? '#000' : '#fff';
                bubble.style.wordWrap = 'break-word';
                bubble.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';

                // Efek animasi muncul
                bubble.style.opacity = 0;
                bubble.style.transform = 'translateY(20px)';
                bubble.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

                div.appendChild(bubble);
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Trigger animasi setelah div ditambahkan ke DOM
                requestAnimationFrame(() => {
                    bubble.style.opacity = 1;
                    bubble.style.transform = 'translateY(0)';
                });
            }

            function showTypingIndicator() {
                const div = document.createElement('div');
                div.classList.add('typing-indicator');
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

                return div; // kita simpan untuk dihapus nanti
            }


            async function getAIIntro() {
                try {
                    const res = await fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message + (articleTitle ?
                                `\n\nKonteks artikel: ${articleTitle} (${articleURL})` : '')
                        })
                    });

                    const data = await res.json();
                    addMessage("🤖 " + data.reply, "ai");
                } catch (err) {
                    console.error(err);
                    addMessage("⚠️ Gagal menghubungi AI. Cek console.", "ai");
                }
            }

            chatButton.addEventListener('click', () => {
                chatBox.style.display = chatBox.style.display === 'none' ? 'block' : 'none';
                if (!aiIntroduced) {
                    aiIntroduced = true;
                    let greeting =
                        "🤖 Hai, hai! Aku SiletBot, asisten berita SiletSumba.com 📰.\n" +
                        "Aku ramah, santai, dan siap bantu kamu ngerti berita lokal tanpa ribet 😎.\n" +
                        "FYI: Aku dikembangkan dan terus diajarin sama Nanu biar makin pintar loh 😉.\n";

                    if (articleTitle) {
                        greeting +=
                            `By the way, ada artikel terbaru nih: "${articleTitle}" (${articleURL}). ` +
                            "Aku bisa ringkas jadi 2-3 kalimat yang gampang dimengerti, tetap seru, dan kadang sambil becanda 😏🎉";
                    }

                    // Bisa tambahkan variasi greeting acak supaya tidak monoton
                    const greetingsVariations = [
                        "Selamat datang! Aku siap jadi teman ngobrolmu tentang berita Sumba 🗞️😄",
                        "Halo! Aku SiletBot, teman santai buat ngerti berita tanpa pusing 🤓",
                        "Hai! Siap kasih ringkasan berita lokal biar tetap seru dan mudah dimengerti 🎈"
                    ];

                    // Pilih salah satu secara acak
                    greeting += "\n\n" + greetingsVariations[Math.floor(Math.random() * greetingsVariations
                        .length)];

                    addMessage(greeting, 'ai');
                }
            });

            chatSend.addEventListener('click', async () => {
                const message = chatInput.value.trim();
                if (!message) return;

                addMessage("👤 " + message, "user");
                chatInput.value = '';
                const typingDiv = showTypingIndicator();

                try {
                    const res = await fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message + (articleTitle ?
                                `\n\nKonteks artikel: ${articleTitle} (${articleURL}) "Jawab pertanyaan user dengan gaya santai dan akrab, sesekali pakai emoji, jangan kaku. Kalau bisa, tambahkan sedikit humor.
                                Selalu bilang kalau masih terus diajar oleh Nanu tergangtung bahasa kamu"` :
                                '')
                        })
                    });

                    const data = await res.json();
                    chatMessages.removeChild(typingDiv);
                    addMessage("🤖 " + data.reply, "ai");
                } catch (err) {
                    console.error(err);
                    addMessage("⚠️ Gagal menghubungi AI. Cek console.", "ai");
                }
            });

            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') chatSend.click();
            });
        });
    </script>

</body>

</html>
