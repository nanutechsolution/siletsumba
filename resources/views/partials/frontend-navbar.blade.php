<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="flex items-center justify-between py-3 border-b flex-wrap">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-lg">S</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-red-600">SILET SUMBA</h1>
                <p class="text-xs text-gray-600">Berita & Inspirasi dari Sumba</p>
            </div>
        </div>

        <!-- Info Cuaca & Waktu (desktop only) -->
        <div class="hidden md:flex items-center space-x-4">
            <div class="flex items-center">
                <!-- Matahari -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8.66-9H21M3 12H2m15.36-6.36l-.7.7M6.34 17.66l-.7.7m12.02 0l.7.7M6.34 6.34l.7.7M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-sm">28°C, Waingapu</span>
            </div>
            <div class="flex items-center">
                <!-- Jam -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6l4 2m6-4a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm" id="current-time"></span>
            </div>
        </div>

        <div class="flex items-center space-x-2 mt-3 md:mt-0">
            <!-- Jika user belum login -->
            @guest
                <a href="{{ route('login') }}"
                    class="bg-red-600 text-white px-3 md:px-4 py-2 rounded hover:bg-red-700 text-sm md:text-base flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Login
                </a>
            @endguest

            <!-- Jika user sudah login -->
            @auth
                <a href="{{ route('profile.edit') }}"
                    class="bg-gray-800 text-white px-3 md:px-4 py-2 rounded hover:bg-gray-700 text-sm md:text-base flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ auth()->user()->name }}
                </a>
            @endauth


            <!-- Burger menu -->
            <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="py-3">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <!-- Links -->
            <div id="menu"
                class="hidden flex-col space-y-2 md:flex md:flex-row md:space-x-6 md:space-y-0 w-full md:w-auto mt-3 md:mt-0">
                <a href="/" class="font-medium text-red-600 hover:text-red-700 flex items-center">
                    <!-- Home icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9.75L12 3l9 6.75V21H3V9.75z" />
                    </svg>
                    Home
                </a>
                @php
                    $currentSlug = request()->route('slug'); // ambil slug dari route
                @endphp
                <div class="flex space-x-4">
                    @foreach ($categories as $category)
                        <a href="{{ route('articles.category', $category->slug) }}"
                            class="font-medium px-2 py-1 rounded
                  {{ $currentSlug === $category->slug ? 'bg-red-600 text-white' : 'text-gray-700 hover:text-red-600' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>


            </div>
            @if (!request()->routeIs('articles.search'))
                <div class="hidden md:flex items-center mt-3 md:mt-0">
                    <form action="{{ route('articles.search') }}" method="GET" class="relative w-full md:w-64">
                        <input type="text" name="q" placeholder="Cari berita..."
                            class="border border-gray-300 rounded-full px-4 py-2 w-full focus:outline-none focus:border-red-600"
                            value="{{ request('q') }}">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </nav>
</div>

<!-- Script Mobile Menu -->
<script>
    const menuToggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");

    menuToggle.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });

    // Waktu realtime
    function updateTime() {
        const now = new Date();
        document.getElementById("current-time").textContent =
            now.toLocaleTimeString("id-ID", {
                hour: "2-digit",
                minute: "2-digit"
            });
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
