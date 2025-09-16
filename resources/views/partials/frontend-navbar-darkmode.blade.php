 <div class="container mx-auto px-4" x-data="{ searchOpen: false, query: '', recent: ['Berita Sumba', 'Politik', 'Olahraga'], filtered: [] }">

     <div class="flex items-center justify-between py-3 border-b flex-wrap">
         <!-- Logo & Nama -->
         <a href="{{ url('/') }}" class="flex items-center gap-4 flex-shrink-0">
             <div class="w-16 h-16  rounded items-center justify-center flex-shrink-0 hidden md:flex">
                 <img src="{{ Storage::url($settings['site_logo_url']->value) }}"
                     alt="{{ $settings['site_name']->value }}" class="w-full h-full object-cover">
             </div>
             <div class="min-w-0">
                 <h1 class="text-xl md:text-2xl font-bold text-red-600 dark:text-red-400 truncate">
                     {{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                 </h1>
                 <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                     {{ $settings['site_description']->value ?? 'Berita & Inspirasi dari Sumba' }}
                 </p>
             </div>
         </a>

         <!-- Search -->
         <div class="relative flex-1 justify-center px-2 mt-3 md:mt-0 items-center">
             <!-- Mobile icon -->
             <button @click="searchOpen = true"
                 class="md:hidden p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                 </svg>
             </button>

             <!-- Desktop form -->
             <form action="{{ route('articles.search') }}" method="GET"
                 class="hidden md:flex relative w-40 md:w-64 focus-within:w-96 transition-all duration-300 ease-in-out">
                 <div
                     class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-400 pointer-events-none">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                     </svg>
                 </div>
                 <input type="text" name="q" placeholder="Cari berita..."
                     class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 transition-all duration-300 ease-in-out"
                     x-model="query"
                     @input="filtered = recent.filter(r => r.toLowerCase().includes(query.toLowerCase()))">
                 <button type="submit" class="hidden"></button>
             </form>

             <!-- Mobile overlay -->
             <div x-show="searchOpen" x-transition x-cloak
                 class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex flex-col items-center p-4">
                 <div class="w-full max-w-md relative">
                     <button @click="searchOpen = false"
                         class="absolute top-4 right-4 z-50 flex items-center space-x-1 px-3 py-2 bg-red-600 text-white rounded-full shadow-md hover:bg-red-700">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M6 18L18 6M6 6l12 12" />
                         </svg>
                         <span class="text-sm font-medium">Batal</span>
                     </button>

                     <form action="{{ route('articles.search') }}" method="GET" class="w-full relative mt-10">
                         <input type="text" name="q" placeholder="Cari berita..." x-model="query"
                             @input="filtered = recent.filter(r => r.toLowerCase().includes(query.toLowerCase()))"
                             autofocus
                             class="w-full pl-4 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 text-lg">
                         <button type="submit" class="hidden"></button>

                         <ul x-show="query.length > 0"
                             class="absolute left-0 right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded shadow max-h-60 overflow-y-auto z-50">
                             <template x-for="item in filtered" :key="item">
                                 <li class="px-4 py-2 hover:bg-red-100 dark:hover:bg-gray-700 cursor-pointer"
                                     @click="query = item; $el.closest('form').submit()">
                                     <span x-text="item"></span>
                                 </li>
                             </template>
                         </ul>
                     </form>
                 </div>
             </div>
         </div>

         <!-- Dark/Light toggle & Auth -->
         <div class="flex items-center space-x-2 mt-3 md:mt-0 flex-shrink-0">
             @guest
                 <a href="{{ route('login') }}" id="loginBtn"
                     class="bg-red-600 text-white px-4 py-2 rounded flex items-center justify-center space-x-2 hover:bg-red-700 transition text-sm md:text-base">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                     </svg>
                     <span>Login</span>
                 </a>
             @endguest

             @auth
                 <x-dropdown align="right" width="48">
                     <x-slot name="trigger">
                         <button
                             class="flex items-center text-sm font-medium text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out hover:text-gray-700 dark:hover:text-gray-300">
                             <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 mr-2">
                                 @if (Auth::user()->profile_photo_path)
                                     <img class="h-full w-full object-cover"
                                         src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                         alt="{{ Auth::user()->name }}">
                                 @else
                                     <div
                                         class="h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                         <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                             </path>
                                         </svg>
                                     </div>
                                 @endif
                             </div>
                             <div class="ms-1">
                                 <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd"
                                         d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                         clip-rule="evenodd" />
                                 </svg>
                             </div>
                         </button>
                     </x-slot>
                     <x-slot name="content">
                         <x-dropdown-link :href="route('admin.dashboard')">Dashboard</x-dropdown-link>
                         <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                         <form method="POST" action="{{ route('logout') }}">
                             @csrf
                             <x-dropdown-link :href="route('logout')"
                                 onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                         </form>
                     </x-slot>
                 </x-dropdown>
             @endauth
         </div>
     </div>

     <!-- Navbar kategori -->
     @php $currentSlug = request()->route('slug'); @endphp
     <nav class="py-3  bg-white dark:bg-gray-900">
         <div class="flex overflow-x-auto scrollbar-hide space-x-4 px-2 whitespace-nowrap w-full">
             <a href="{{ url('/') }}"
                 class="px-2 py-2 flex-shrink-0 {{ request()->is('/') ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-700 dark:text-gray-300 hover:text-red-600' }}">Beranda</a>
             @foreach ($categories as $category)
                 <a href="{{ route('articles.category', $category->slug) }}"
                     class="px-2 py-2 flex-shrink-0 {{ $currentSlug === $category->slug ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-700 dark:text-gray-300 hover:text-red-600' }}">{{ $category->name }}</a>
             @endforeach
         </div>
     </nav>
 </div>

 <script>
     document.addEventListener('DOMContentLoaded', () => {
         const loginBtn = document.getElementById('loginBtn');
         if (!loginBtn) return;

         loginBtn.addEventListener('click', function() {
             // hide old icon
             const oldIcon = this.querySelector('svg');
             if (oldIcon) oldIcon.style.display = 'none';

             // add spinner
             const spinner = document.createElement('div');
             spinner.className =
                 'animate-spin h-5 w-5 border-2 border-t-2 border-white border-t-transparent rounded-full mr-1';
             this.prepend(spinner);

             // disable tombol biar ga diklik lagi
             this.classList.add('opacity-70', 'cursor-not-allowed');
         });
     });
 </script>
