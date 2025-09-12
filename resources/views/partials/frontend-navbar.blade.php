<div class="container mx-auto px-4">
    <div class="flex items-center justify-between py-3 border-b flex-wrap">
        <!-- Logo -->
        <div class="flex items-center gap-4 flex-shrink-0">
            <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-lg">S</span>
            </div>

            <div class="min-w-0">
                <h1 class="text-xl md:text-2xl font-bold text-red-600 dark:text-red-400 truncate">
                    {{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                </h1>
                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                    {{ $settings['site_description']->value ?? 'Berita & Inspirasi dari Sumba' }}
                </p>
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

        <div class="flex items-center space-x-2 mt-3 md:mt-0 flex-shrink-0">
            @guest
                <a href="{{ route('login') }}"
                    class="bg-red-600 text-white px-3 md:px-4 py-2 rounded hover:bg-red-700 transition text-sm md:text-base flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            @endguest

            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out hover:text-gray-700 dark:hover:text-gray-300">
                            <div class="h-8 w-8 rounded-full overflow-hidden flex-shrink-0 mr-2">
                                @if (Auth::user()->profile_photo_path)
                                    <img class="h-full w-full object-cover"
                                        src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <div
                                        class="h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endauth
        </div>
    </div>

    @php
        $currentSlug = request()->route('slug');
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
