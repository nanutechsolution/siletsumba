<nav x-data="{ open: false }" class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <a href="{{ route('admin.dashboard') }}"> <x-application-logo
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                    {{-- <img src="{{ asset('storage/logo-silet.png') }}" class="h-8" alt="Silet Sumba Logo" /> --}}
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Silet
                        Sumba</span>
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition duration-150 ease-in-out">
                    Beranda
                </a>
                <a href="#"
                    class="text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition duration-150 ease-in-out">
                    Kategori
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button id="theme-toggle-frontend" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-2">
                    <svg id="theme-toggle-dark-icon-frontend" class="hidden w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.293 13.593a.999.999 0 01-1.414 0L10 8.414l-5.879 5.179a.999.999 0 11-1.414-1.414l6.586-5.879a.999.999 0 011.414 0l6.586 5.879a.999.999 0 010 1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon-frontend" class="hidden w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm3.707 3.707a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm15 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm-3.707-3.707a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM10 15a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-3.707-3.707a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414zM4.3 12.7a1 1 0 01-1.4 1.4L2.2 14.1a1 1 0 011.4-1.4l.7.7zM14.1 2.2a1 1 0 011.4 1.4l-.7.7a1 1 0 01-1.4-1.4l.7-.7z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
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

    <div x-show="open" x-cloak class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block px-4 py-2 text-base font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">Beranda</a>
            <a href="#"
                class="block px-4 py-2 text-base font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">Kategori</a>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 py-2">
                <button id="theme-toggle-mobile-frontend" type="button"
                    class="flex w-full ps-3 pe-4 py-2 text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-100 dark:focus:bg-gray-900 transition duration-150 ease-in-out">
                    <svg id="theme-toggle-dark-icon-mobile-frontend" class="hidden w-5 h-5 me-2" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.293 13.593a.999.999 0 01-1.414 0L10 8.414l-5.879 5.179a.999.999 0 11-1.414-1.414l6.586-5.879a.999.999 0 011.414 0l6.586 5.879a.999.999 0 010 1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon-mobile-frontend" class="hidden w-5 h-5 me-2" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm3.707 3.707a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm15 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm-3.707-3.707a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM10 15a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-3.707-3.707a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414zM4.3 12.7a1 1 0 01-1.4 1.4L2.2 14.1a1 1 0 011.4-1.4l.7.7zM14.1 2.2a1 1 0 011.4 1.4l-.7.7a1 1 0 01-1.4-1.4l.7-.7z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                    <span class="ms-2">Ganti Mode Tema</span>
                </button>
            </div>
        </div>
    </div>
</nav>
<script>
    // ... Kode JS untuk dark mode (gunakan ID yang berbeda) ...
    var themeToggleDarkIconFrontend = document.getElementById('theme-toggle-dark-icon-frontend');
    var themeToggleLightIconFrontend = document.getElementById('theme-toggle-light-icon-frontend');
    var themeToggleBtnFrontend = document.getElementById('theme-toggle-frontend');

    // ... (dan untuk mobile) ...
    var themeToggleDarkIconMobileFrontend = document.getElementById('theme-toggle-dark-icon-mobile-frontend');
    var themeToggleLightIconMobileFrontend = document.getElementById('theme-toggle-light-icon-mobile-frontend');
    var themeToggleBtnMobileFrontend = document.getElementById('theme-toggle-mobile-frontend');

    // Initial check and logic (replicate from Admin Panel but with new IDs)
    // ... (kode dari langkah 12) ...
</script>
