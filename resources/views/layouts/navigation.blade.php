<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 fixed top-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-4 min-w-0">
                <div class="min-w-0">
                    <h1 class="text-xl md:text-2xl font-bold text-red-600 dark:text-red-400 truncate">
                        {{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                    </h1>
                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                        {{ $settings['site_description']->value ?? 'Berita & Inspirasi dari Sumba' }}
                    </p>
                </div>
            </a>
            <!-- Desktop Menu -->
            <div class="hidden sm:flex items-center space-x-4 flex-wrap overflow-x-auto max-w-full">
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link>
                @can('buat_artikel')
                    <x-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">Berita</x-nav-link>
                @endcan
                @can('kelola_komentar')
                    <x-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')" class="relative">
                        <span class="flex items-center">
                            Komentar
                            @if ($pendingComments > 0)
                                <span
                                    class="ms-2 px-2 py-1 text-xs font-bold text-red-100 dark:text-red-900 bg-red-600 dark:bg-red-300 rounded-full">
                                    {{ $pendingComments }}
                                </span>
                            @endif
                        </span>
                    </x-nav-link>
                @endcan
                @role('admin')
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">Kategori</x-nav-link>
                    <x-nav-link :href="route('admin.prompts.index')" :active="request()->routeIs('admin.prompts.*')">Prompt AI</x-nav-link>
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">Pengguna</x-nav-link>
                    <x-nav-link :href="route('admin.tags.index')" :active="request()->routeIs('admin.tags.*')">Tag</x-nav-link>
                    <x-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">Halaman Statis</x-nav-link>
                    <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">Pengaturan</x-nav-link>
                @endrole
            </div>
            <!-- Theme Toggle + User Dropdown -->

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle-desktop" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2.5">
                    <svg id="theme-icon-desktop" class="w-5 h-5 transition-transform duration-300" fill="currentColor"
                        viewBox="0 0 20 20"></svg>
                </button>
                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4 ms-1" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('home')">Kembali Ke Web</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">Log
                                Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button id="theme-toggle-mobile" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2.5">
                    <svg id="theme-icon-mobile" class="w-5 h-5 transition-transform duration-300" fill="currentColor"
                        viewBox="0 0 20 20"></svg>
                </button>
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden px-2 pt-2 pb-3 space-y-1" x-transition>
        <!-- Nav Links -->
        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">Berita</x-responsive-nav-link>
        @role('admin')
            <x-responsive-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')">Komentar</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">Kategori</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.prompts.index')" :active="request()->routeIs('admin.prompts.*')">Prompt AI</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">Pengguna</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.tags.index')" :active="request()->routeIs('admin.tags.*')">Tag</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">Halaman Statis</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">Pengaturan</x-responsive-nav-link>
        @endrole

        <!-- User Menu -->
        <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('home')">Kembali Ke Web</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = [{
                btn: document.getElementById('theme-toggle-desktop'),
                icon: document.getElementById('theme-icon-desktop')
            },
            {
                btn: document.getElementById('theme-toggle-mobile'),
                icon: document.getElementById('theme-icon-mobile')
            }
        ];

        const moonIconPath = "M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z";
        const sunIconPath =
            "M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z";

        function setIcon(element, isDark) {
            if (element) element.innerHTML =
                `<path d="${isDark ? sunIconPath : moonIconPath}" fill-rule="evenodd" clip-rule="evenodd"/>`;
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
            toggleButtons.forEach(t => setIcon(t.icon, !isDark));
        }

        const isDarkInitial = localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

        if (isDarkInitial) document.documentElement.classList.add('dark');
        toggleButtons.forEach(t => setIcon(t.icon, isDarkInitial));
        toggleButtons.forEach(t => t.btn.addEventListener('click', toggleTheme));
    });
</script>
