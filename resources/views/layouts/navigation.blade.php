<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-4 flex-shrink-0">
                        <div class="min-w-0">
                            <h1 class="text-xl md:text-2xl font-bold text-red-600 dark:text-red-400 truncate">
                                {{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                            </h1>
                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                                {{ $settings['site_description']->value ?? 'Berita & Inspirasi dari Sumba' }}
                            </p>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @can('buat_artikel')
                        <x-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">
                            {{ __('Berita') }}
                        </x-nav-link>
                    @endcan
                    @can('kelola_komentar')
                        {{-- Notifikasi Komentar --}}
                        <x-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')" class="relative">
                            <span class="flex items-center">
                                {{ __('Komentar') }}
                                @if ($pendingComments > 0)
                                    <span
                                        class="ms-2 px-2 py-1 text-xs font-bold leading-none text-red-100 dark:text-red-900 bg-red-600 dark:bg-red-300 rounded-full">
                                        {{ $pendingComments }}
                                    </span>
                                @endif
                            </span>
                        </x-nav-link>
                    @endcan
                    @role('admin')
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Kategori') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.prompts.index')" :active="request()->routeIs('admin.prompts.*')">
                            {{ __('Prompt AI') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Pengguna') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.tags.index')" :active="request()->routeIs('admin.tags.*')">
                            {{ __('Tag') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                            {{ __('Halaman Statis') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                            {{ __('Pengaturan') }}
                        </x-nav-link>
                        {{-- <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                            {{ __('Manajemen Role') }}
                        </x-nav-link> --}}
                    @endrole
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-icon" class="w-5 h-5 transition-transform duration-300" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('home')">{{ __('Kembali Ke Web') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button id="theme-toggle-responsive" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-2">
                    <svg id="theme-icon-responsive" class="w-5 h-5 transition-transform duration-300"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></svg>
                </button>
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard Admin') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">
                {{ __('Berita') }}
            </x-responsive-nav-link>
            @role('admin')
                {{-- Notifikasi Komentar Responsif --}}
                <x-responsive-nav-link :href="route('admin.comments.index')" :active="request()->routeIs('admin.comments.*')">
                    <span class="flex items-center">
                        {{ __('Komentar') }}
                        @if ($pendingComments > 0)
                            <span
                                class="ms-2 px-2 py-1 text-xs font-bold leading-none text-red-100 dark:text-red-900 bg-red-600 dark:bg-red-300 rounded-full">
                                {{ $pendingComments }}
                            </span>
                        @endif
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    {{ __('Kategori') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.prompts.index')" :active="request()->routeIs('admin.prompts.*')">
                    {{ __('Prompt AI') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tags.index')" :active="request()->routeIs('admin.tags.*')">
                    {{ __('Tag') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                    {{ __('Halaman Statis') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
                {{-- <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                    {{ __('Role') }}
                </x-responsive-nav-link> --}}
            @endrole
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('home')">{{ __('Kembali Ke Web') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleBtnResponsive = document.getElementById('theme-toggle-responsive');
        const themeIcon = document.getElementById('theme-icon');
        const themeIconResponsive = document.getElementById('theme-icon-responsive');

        // SVG Path for Icons
        const moonIconPath = "M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z";
        const sunIconPath =
            "M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z";

        function setIcon(element, isDark) {
            if (element) {
                element.innerHTML =
                    `<path d="${isDark ? sunIconPath : moonIconPath}" fill-rule="evenodd" clip-rule="evenodd"></path>`;
            }
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
            setIcon(themeIcon, !isDark);
            setIcon(themeIconResponsive, !isDark);
        }

        // Initial check and set icons
        const isDarkInitial = localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in
            localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        if (isDarkInitial) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        setIcon(themeIcon, isDarkInitial);
        setIcon(themeIconResponsive, isDarkInitial);

        // Event listeners
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', toggleTheme);
        }
        if (themeToggleBtnResponsive) {
            themeToggleBtnResponsive.addEventListener('click', toggleTheme);
        }
    });
</script>
