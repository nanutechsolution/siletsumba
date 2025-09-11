<div class="container mx-auto px-4">
    <div class="flex items-center justify-between py-3 border-b flex-wrap">
        <!-- Logo -->
        <div class="flex items-center space-x-2 flex-shrink-0">
            <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center">
                <span class="text-white font-bold text-lg">S</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-red-600">SILET SUMBA</h1>
                <p class="text-xs text-gray-600">Berita & Inspirasi dari Sumba</p>
            </div>
        </div>

        <!-- Search (centered) -->
        @if (!request()->routeIs('articles.search'))
            <div class="hidden md:flex flex-1 justify-center px-6">
                <form action="{{ route('articles.search') }}" method="GET" class="relative w-full max-w-md">
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

        <!-- User & Burger Menu -->
        <div class="flex items-center space-x-2 mt-3 md:mt-0 flex-shrink-0">
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

        </div>
    </div>

    @php
        $currentSlug = request()->route('slug'); // ambil slug dari route
    @endphp
    <!-- Navbar -->
    <nav class="py-3 border-b bg-white">
        <div class="flex">
            <!-- Scrollable categories -->
            <div class="flex overflow-x-auto scrollbar-hide space-x-4 px-2 whitespace-nowrap w-full">
                <a href="{{ url('/') }}"
                    class="px-2 py-2 flex-shrink-0 
                {{ request()->is('/') ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-700 hover:text-red-600' }}">
                    Home
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('articles.category', $category->slug) }}"
                        class="px-2 py-2 flex-shrink-0 
        {{ $currentSlug === $category->slug ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-700 hover:text-red-600' }}">
                        {{ $category->name }}
                    </a>
                @endforeach

            </div>
        </div>
    </nav>
</div>
