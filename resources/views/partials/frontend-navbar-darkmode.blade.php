{{-- ===== Utility bar ===== --}}
<div class="bg-stone-900 text-stone-300">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-1.5 text-xs">
        <span class="truncate">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>

        <div class="flex flex-shrink-0 items-center gap-3">
            <button type="button" @click="toggleDarkMode()" aria-label="Ganti mode terang atau gelap"
                class="flex h-7 w-7 items-center justify-center rounded-full hover:bg-stone-700 hover:text-white">
                <svg x-show="!darkMode" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z" />
                </svg>
                <svg x-show="darkMode" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path stroke-linecap="round" d="M12 2v2m0 16v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                </svg>
            </button>

            @guest
            <a href="{{ route('login') }}" class="rounded-full border border-stone-600 px-3 py-1 font-medium text-stone-200 hover:border-white hover:text-white">Masuk</a>
            @endguest

            @auth
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 text-xs font-medium text-stone-200 hover:text-white">
                        <span class="h-7 w-7 overflow-hidden rounded-full bg-stone-700">
                            @if (Auth::user()->hasMedia('profile_photos'))
                            <img class="h-full w-full object-cover" loading="lazy" src="{{ Auth::user()->getFirstMediaUrl('profile_photos', 'small') }}" alt="{{ Auth::user()->name }}">
                            @else
                            <span class="flex h-full w-full items-center justify-center">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </span>
                            @endif
                        </span>
                        <span class="hidden max-w-[8rem] truncate sm:inline">{{ Auth::user()->name }}</span>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('admin.dashboard')">Dashboard</x-dropdown-link>
                    @can('buat_artikel')
                    <x-dropdown-link :href="route('admin.articles.create')">Buat berita</x-dropdown-link>
                    @endcan
                    <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
            @endauth
        </div>
    </div>
</div>

{{-- ===== Masthead ===== --}}
<header class="border-b border-stone-200 bg-silet-paper dark:border-stone-800 dark:bg-stone-950"
    x-data="{
        searchOpen: false,
        query: '',
        recent: {{ Js::from($popularSearches->pluck('query')) }},
        get filtered() {
            const q = this.query.toLowerCase();
            return this.recent.filter(r => r.toLowerCase().includes(q));
        }
    }"
    @keydown.escape.window="searchOpen = false"
    @buka-cari.window="searchOpen = true; $nextTick(() => $refs.mobileSearch.focus())">

    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 md:py-5">
        <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-3">
            @php
            $logoSetting = $settings['site_logo_url'] ?? null;
            $logoUrl = $logoSetting?->getFirstMediaUrl('site_logo_url', 'thumb');
            @endphp
            @if ($logoUrl)
            <img src="{{ $logoUrl }}" alt="Logo {{ $settings['site_name']->value ?? 'Silet Sumba' }}" class="h-10 w-10 flex-shrink-0 rounded object-cover md:h-14 md:w-14">
            @endif
            <div class="min-w-0">
                <p class="truncate font-serif text-2xl font-bold leading-none tracking-tight text-silet-red md:text-4xl">
                    {{ $settings['site_name']->value ?? 'Silet Sumba' }}
                </p>
                <p class="mt-1 truncate text-[11px] uppercase tracking-[0.18em] text-stone-500 dark:text-stone-400 md:text-xs">
                    {{ $settings['site_description']->value ?? 'Berita & inspirasi dari Sumba' }}
                </p>
            </div>
        </a>

        {{-- Cari: tombol (mobile) --}}
        <button type="button" @click="searchOpen = true; $nextTick(() => $refs.mobileSearch.focus())" aria-label="Buka pencarian"
            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border border-stone-300 text-stone-700 dark:border-stone-700 dark:text-stone-200 md:hidden">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M17 10a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </button>

        {{-- Cari: form (desktop) --}}
        <form action="{{ route('articles.search') }}" method="GET" class="relative hidden w-64 flex-shrink-0 transition-all duration-300 focus-within:w-96 md:block">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M17 10a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="search" name="q" x-model="query" placeholder="Cari berita" autocomplete="off"
                class="w-full rounded-full border-stone-300 bg-white py-2 pl-10 pr-4 text-sm shadow-sm focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100">
        </form>
    </div>

    {{-- Overlay pencarian (mobile) --}}
    <div x-show="searchOpen" x-cloak x-transition.opacity class="fixed inset-0 z-[80] bg-silet-paper p-4 dark:bg-stone-950">
        <div class="mx-auto max-w-md">
            <div class="flex items-center justify-between">
                <p class="font-serif text-xl font-bold">Cari berita</p>
                <button type="button" @click="searchOpen = false" aria-label="Tutup pencarian" class="flex h-10 w-10 items-center justify-center rounded-full border border-stone-300 dark:border-stone-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('articles.search') }}" method="GET" class="mt-4">
                <input type="search" name="q" x-ref="mobileSearch" x-model="query" placeholder="Ketik kata kunci" autocomplete="off"
                    class="w-full rounded-full border-stone-300 bg-white px-4 py-3 text-base shadow-sm focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100">
            </form>
            <ul x-show="query.length > 0 && filtered.length > 0" class="mt-3 divide-y divide-stone-200 overflow-hidden rounded-lg border border-stone-200 bg-white dark:divide-stone-800 dark:border-stone-800 dark:bg-stone-900">
                <template x-for="item in filtered" :key="item">
                    <li>
                        <button type="button" class="w-full px-4 py-3 text-left text-sm hover:bg-stone-100 dark:hover:bg-stone-800"
                            @click="query = item; $nextTick(() => $el.closest('div').querySelector('form').submit())" x-text="item"></button>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <div class="tenun-strip" aria-hidden="true"></div>
</header>

{{-- ===== Menu kategori (sticky) + nama media saat scroll ===== --}}
@php $currentSlug = request()->route('slug'); @endphp
<nav aria-label="Kategori berita"
    x-data="{ scrolled: false }"
    x-init="scrolled = $el.previousElementSibling.getBoundingClientRect().bottom <= 0"
    @scroll.window.passive="scrolled = $el.previousElementSibling.getBoundingClientRect().bottom <= 0"
    class="sticky top-0 z-40 border-b border-stone-200 bg-silet-paper/95 backdrop-blur dark:border-stone-800 dark:bg-stone-950/95"
    :class="scrolled ? 'shadow-md' : ''">
    <div class="mx-auto flex max-w-7xl items-center px-4">

        {{-- Nama media: tampil saat header utama sudah tergulung --}}
        <a href="{{ url('/') }}" aria-label="Ke beranda {{ $settings['site_name']->value ?? 'Silet Sumba' }}"
            class="flex flex-shrink-0 items-center gap-2 overflow-hidden whitespace-nowrap transition-all duration-300"
            :class="scrolled ? 'mr-3 max-w-[11rem] opacity-100' : 'mr-0 max-w-0 opacity-0'"
            :tabindex="scrolled ? 0 : -1" :aria-hidden="scrolled ? 'false' : 'true'">
            @if ($logoUrl)
            <img src="{{ $logoUrl }}" alt="" class="h-7 w-7 flex-shrink-0 rounded object-cover">
            @endif
            <span class="font-serif text-lg font-bold leading-none tracking-tight text-silet-red">{{ $settings['site_name']->value ?? 'Silet Sumba' }}</span>
        </a>

        <div class="scrollbar-hide -mx-1 flex min-w-0 flex-1 gap-1 overflow-x-auto whitespace-nowrap text-sm font-medium">
            <a href="{{ url('/') }}"
                class="flex-shrink-0 border-b-2 px-3 py-3 {{ request()->is('/') ? 'border-silet-red text-silet-red' : 'border-transparent text-stone-600 hover:text-silet-red dark:text-stone-300' }}">
                Beranda
            </a>
            @foreach ($footerCategories as $category)
            <a href="{{ route('articles.category', $category->slug) }}"
                class="flex-shrink-0 border-b-2 px-3 py-3 {{ $currentSlug === $category->slug ? 'border-silet-red text-silet-red' : 'border-transparent text-stone-600 hover:text-silet-red dark:text-stone-300' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>

        {{-- Tombol cari: muncul saat scroll --}}
        <button type="button" @click="$dispatch('buka-cari')" aria-label="Cari berita"
            class="ml-2 flex h-9 w-9 flex-shrink-0 items-center justify-center overflow-hidden rounded-full border border-stone-300 text-stone-700 transition-all duration-300 dark:border-stone-700 dark:text-stone-200"
            :class="scrolled ? 'opacity-100' : 'pointer-events-none w-0 border-0 opacity-0'">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M17 10a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </button>
    </div>
</nav>
