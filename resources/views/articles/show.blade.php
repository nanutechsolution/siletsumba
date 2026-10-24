@extends('welcome')

@section('content')
@php
    $waktuTerbit = \Carbon\Carbon::parse($article->scheduled_at ?? $article->created_at)->locale('id');
    $judulPolos = strip_tags($article->title);
    $shareUrl = url()->current();
    $konten = explode('</p>', $article->full_content_with_ads);
    $menitBaca = max(1, (int) ceil(str_word_count(strip_tags($article->content)) / 200));
    $gambar = $article->getFirstMedia('images');
    $jumlahKomentar = $article->comments()->where('status', 'approved')->count();
    $kategori = $article->category;
    $bacaJugaTampil = false;
@endphp

<div x-data="artikelPage(@js($judulPolos), @js($shareUrl))" @scroll.window.passive="hitungProgress()">

    {{-- Bilah progres baca --}}
    <div class="fixed inset-x-0 top-0 z-[70] h-1" aria-hidden="true">
        <div class="h-full bg-silet-red transition-[width] duration-150" :style="`width:${progress}%`"></div>
    </div>

    @if (!$article->is_published)
    <div class="mb-4 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-700 dark:bg-amber-950 dark:text-amber-200">
        <p class="font-semibold">Mode pratinjau</p>
        <p class="mt-1">Berita ini belum dipublikasikan. Jangan dibagikan ke publik sebelum statusnya tayang.</p>
    </div>
    @endif

    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" class="scrollbar-hide mb-4 flex items-center gap-1.5 overflow-x-auto whitespace-nowrap text-xs text-stone-500 dark:text-stone-400">
        <a href="{{ url('/') }}" class="hover:text-silet-red">Beranda</a>
        @if ($kategori?->parent)
        <span aria-hidden="true">/</span>
        <a href="{{ route('articles.category', $kategori->parent->slug) }}" class="hover:text-silet-red">{{ $kategori->parent->name }}</a>
        @endif
        @if ($kategori)
        <span aria-hidden="true">/</span>
        <a href="{{ route('articles.category', $kategori->slug) }}" class="font-medium text-stone-700 hover:text-silet-red dark:text-stone-200">{{ $kategori->name }}</a>
        @endif
    </nav>

    <div class="grid gap-10 lg:grid-cols-12">
        <div class="lg:col-span-8">
            <article>
                <header class="mx-auto max-w-[42rem] lg:mx-0">
                    @if ($kategori)
                    <a href="{{ route('articles.category', $kategori->slug) }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-stone-600 dark:text-stone-300">
                        <span class="h-2 w-2 rounded-sm" style="background-color: {{ $kategori->color ?? '#E41E2D' }}"></span>
                        {{ $kategori->name }}
                    </a>
                    @endif

                    <h1 class="mt-2 font-serif text-[1.75rem] font-bold leading-[1.2] tracking-tight sm:text-4xl lg:text-[2.5rem]">
                        {{ $judulPolos }}
                    </h1>

                    @if (!empty($article->excerpt))
                    <p class="mt-3 font-serif text-lg leading-relaxed text-stone-600 dark:text-stone-300">{{ $article->excerpt }}</p>
                    @endif

                    {{-- Byline --}}
                    <div class="mt-5 flex items-center gap-3 border-y border-stone-200 py-3 dark:border-stone-800">
                        <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-full bg-stone-200 dark:bg-stone-800">
                            @if ($article->user?->hasMedia('profile_photos'))
                            <img src="{{ $article->user->getFirstMediaUrl('profile_photos', 'small') }}" alt="{{ $article->user->name }}" class="h-full w-full object-cover" loading="lazy">
                            @else
                            <span class="flex h-full w-full items-center justify-center text-sm font-semibold text-stone-600 dark:text-stone-300">{{ strtoupper(mb_substr($article->user->name ?? 'R', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1 text-sm">
                            <p class="truncate font-semibold">{{ $article->user->name ?? 'Redaksi' }}</p>
                            <p class="text-xs text-stone-500 dark:text-stone-400">
                                <time datetime="{{ $waktuTerbit->toIso8601String() }}">{{ $waktuTerbit->translatedFormat('j F Y, H:i') }} WITA</time>
                                · {{ $menitBaca }} menit baca
                                @auth · {{ number_format($article->views) }} dibaca @endauth
                            </p>
                        </div>

                        {{-- Ukuran huruf --}}
                        <div class="flex flex-shrink-0 items-center overflow-hidden rounded-full border border-stone-300 text-stone-700 dark:border-stone-700 dark:text-stone-200" role="group" aria-label="Ukuran huruf">
                            <button type="button" @click="ubahUkuran(-1)" aria-label="Perkecil huruf" class="px-3 py-1.5 text-xs hover:bg-stone-100 dark:hover:bg-stone-800">A−</button>
                            <button type="button" @click="ubahUkuran(1)" aria-label="Perbesar huruf" class="border-l border-stone-300 px-3 py-1.5 text-base font-semibold hover:bg-stone-100 dark:border-stone-700 dark:hover:bg-stone-800">A+</button>
                        </div>
                    </div>
                </header>

                {{-- Gambar utama: penuh lebar di HP --}}
                @if ($gambar)
                <figure class="-mx-4 mt-5 sm:mx-0">
                    <img src="{{ $gambar->getUrl('responsive') }}" srcset="{{ $gambar->getSrcset('responsive') }}"
                        sizes="(max-width: 1024px) 100vw, 800px" alt="{{ $judulPolos }}"
                        class="h-auto w-full bg-stone-200 object-cover sm:rounded-lg dark:bg-stone-800"
                        loading="eager" fetchpriority="high" decoding="async">
                </figure>
                @endif

                {{-- Isi berita --}}
                <div x-ref="body" class="mx-auto mt-6 max-w-[42rem] lg:mx-0">
                    <div class="prose prose-stone max-w-none font-serif dark:prose-invert prose-headings:font-serif prose-headings:font-bold prose-headings:tracking-tight prose-p:leading-[1.8] prose-a:text-silet-red prose-a:no-underline hover:prose-a:underline prose-blockquote:border-silet-red prose-blockquote:font-serif prose-img:rounded-lg"
                        style="font-size:1.125rem" :style="`font-size:${ukuran[indeks]}rem`">
                        @foreach ($konten as $paragraf)
                            @if (preg_match('/<p[\s>]/', $paragraf)){!! $paragraf !!}</p>@else{!! $paragraf !!}@endif

                            @if (!$bacaJugaTampil && $loop->iteration === 3 && $related->isNotEmpty())
                            <aside class="not-prose my-8 rounded-lg border-l-4 border-silet-red bg-stone-100 px-4 py-3 font-sans dark:bg-stone-900">
                                <p class="text-xs font-semibold uppercase tracking-wider text-silet-red">Baca juga</p>
                                <a href="{{ route('articles.show', $related[0]->slug) }}" class="mt-1 block font-serif text-lg font-semibold leading-snug hover:text-silet-red">
                                    {{ strip_tags($related[0]->title) }}
                                </a>
                            </aside>
                            @php $bacaJugaTampil = true; @endphp
                            @endif
                        @endforeach
                    </div>

                    {{-- Tag --}}
                    @if ($article->tags->count())
                    <div class="mt-8 flex flex-wrap gap-2" aria-label="Tag">
                        @foreach ($article->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="rounded-full bg-stone-200 px-3 py-1.5 text-sm text-stone-700 hover:bg-silet-red hover:text-white dark:bg-stone-800 dark:text-stone-300">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    @endif

                    {{-- Aksi: suka, komentar, bagikan --}}
                    @if ($article->is_published)
                    <div class="mt-8 rounded-xl border border-stone-200 p-4 dark:border-stone-800">
                        <p class="text-sm font-semibold">Bagikan berita ini</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($judulPolos . ' ' . $shareUrl) }}" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-2 rounded-full bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.51c.88.2 1.5.98 1.5 1.89v4.28c0 1.1-.77 2.05-1.85 2.26-.76.14-1.53.26-2.31.34-.3.03-.57.2-.73.45L15 20.25l-1.89-2.86a.9.9 0 0 0-.73-.45 22 22 0 0 1-2.31-.34 2.3 2.3 0 0 1-1.85-2.26V10.4c0-.9.62-1.69 1.5-1.89 1.7-.36 3.48-.55 5.28-.55s3.58.19 5.25.55zM15.75 8.25V6.5c0-1.4-1.1-2.57-2.5-2.69a37 37 0 0 0-6.5 0A2.7 2.7 0 0 0 4.25 6.5v4.28c0 1.1.77 2.05 1.85 2.26" /></svg>
                                Kirim ke WhatsApp
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" aria-label="Bagikan ke Facebook"
                                class="flex h-11 w-11 items-center justify-center rounded-full border border-stone-300 text-stone-700 hover:border-blue-600 hover:text-blue-600 dark:border-stone-700 dark:text-stone-200">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 320 512" aria-hidden="true"><path d="M279.14 288l14.22-92.66h-88.91V131.36c0-25.35 12.42-50.06 52.24-50.06H293V6.26S273.49 0 256.36 0c-73.22 0-121 44.38-121 124.72V195.3H86.24V288h49.12v224h100.2V288z" /></svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($judulPolos) }}" target="_blank" rel="noopener" aria-label="Bagikan ke X"
                                class="flex h-11 w-11 items-center justify-center rounded-full border border-stone-300 text-stone-700 hover:border-stone-900 hover:text-stone-900 dark:border-stone-700 dark:text-stone-200 dark:hover:border-white dark:hover:text-white">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 512 512" aria-hidden="true"><path d="M459.4 151.7c.3 4.1 .3 8.2 .3 12.3 0 125-95.2 269-269 269-53.4 0-102.9-15.6-144.6-42.4 7.4 .9 14.8 1.2 22.4 1.2 44.3 0 85-15.1 117.4-40.8-41.3-.8-76.1-28-88.1-65.3 5.7 .9 11.3 1.4 17.3 1.4 8.2 0 16.2-1.1 23.8-3.2-43.2-8.7-75.7-46.7-75.7-92.4v-1.2c12.7 7.1 27.3 11.4 42.8 11.9-25.3-17-42-46-42-78.9 0-17.3 4.7-33.4 12.9-47.3 46 56.5 114.7 93.7 192 97.6-1.6-7-2.5-14.3-2.5-21.8 0-52.9 42.9-95.8 95.8-95.8 27.5 0 52.3 11.6 69.7 30.2 21.8-4.3 42.3-12.3 60.7-23.4-7.2 22.5-22.5 41.3-42.6 53.1 19.3-2.2 37.7-7.4 54.9-15-12.8 19-29 35.8-47.8 49.2z" /></svg>
                            </a>
                            <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($judulPolos) }}" target="_blank" rel="noopener" aria-label="Bagikan ke Telegram"
                                class="flex h-11 w-11 items-center justify-center rounded-full border border-stone-300 text-stone-700 hover:border-sky-500 hover:text-sky-500 dark:border-stone-700 dark:text-stone-200">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 240 240" aria-hidden="true"><path d="M120 0C53.73 0 0 53.73 0 120s53.73 120 120 120 120-53.73 120-120S186.27 0 120 0zm58.2 81.6l-21.1 99.3c-1.6 7.1-5.8 8.9-11.7 5.5l-32.3-23.9-15.6 15c-1.7 1.7-3.1 3.1-6.4 3.1l2.3-32.4 59-53.3c2.6-2.3-.6-3.6-4-1.3l-73 45.9-31.5-9.8c-6.8-2.1-6.9-6.8 1.5-10.1l123-47.4c5.7-2.2 10.7 1.4 8.8 10z" /></svg>
                            </a>
                            <button type="button" @click="salin()" aria-label="Salin tautan"
                                class="flex h-11 items-center gap-2 rounded-full border border-stone-300 px-4 text-sm text-stone-700 hover:border-stone-900 dark:border-stone-700 dark:text-stone-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.2 10.8a4 4 0 0 1 0 5.7l-2.7 2.7a4 4 0 0 1-5.7-5.7l1.2-1.2m10.6-3.6 1.2-1.2a4 4 0 0 0-5.7-5.7L10.5 7.2a4 4 0 0 0 0 5.7" /></svg>
                                <span x-text="tersalin ? 'Tersalin' : 'Salin tautan'">Salin tautan</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </article>

            {{-- Lanjut membaca (khusus HP; di desktop ada di sidebar) --}}
            <section class="mx-auto mt-10 max-w-[42rem] lg:hidden" aria-label="Berita lainnya">
                <div class="border-t-2 border-silet-red pt-3">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Lanjut membaca</h2>
                </div>
                <div class="divide-y divide-stone-200 dark:divide-stone-800">
                    @foreach ($latest->where('id', '!=', $article->id)->take(4) as $item)
                    <a href="{{ route('articles.show', $item->slug) }}" class="block py-3 font-serif text-lg font-semibold leading-snug">{{ strip_tags($item->title) }}</a>
                    @endforeach
                </div>
            </section>

            {{-- Komentar --}}
            <div class="mx-auto mt-10 max-w-[42rem] lg:mx-0">
                @include('partials.article-comments', ['article' => $article])
            </div>
        </div>

        <aside class="lg:col-span-4">
            @include('partials.sidebar', ['popular' => $popular, 'latest' => $latest])
        </aside>
    </div>

    {{-- Bilah aksi bawah (HP) --}}
    @if ($article->is_published)
    <div class="fixed inset-x-0 bottom-0 z-50 border-t border-stone-200 bg-silet-paper/95 backdrop-blur dark:border-stone-800 dark:bg-stone-950/95 lg:hidden" style="padding-bottom: env(safe-area-inset-bottom)">
        <div class="mx-auto flex max-w-7xl items-center gap-2 px-4 py-2">
            @guest
            <button type="button" @click="loginOpen = true" class="flex h-11 items-center gap-1.5 rounded-full border border-stone-300 px-3 text-sm dark:border-stone-700" aria-label="Suka berita ini">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.49-2.1-4.5-4.69-4.5-1.94 0-3.6 1.12-4.31 2.73A4.74 4.74 0 0 0 7.69 3.75C5.1 3.75 3 5.76 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                {{ number_format($article->likes) }}
            </button>
            @endguest
            @auth
            <form action="{{ route('articles.like', $article->slug) }}" method="POST">
                @csrf
                <button type="submit" class="flex h-11 items-center gap-1.5 rounded-full border border-stone-300 px-3 text-sm dark:border-stone-700" aria-label="Suka berita ini">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.49-2.1-4.5-4.69-4.5-1.94 0-3.6 1.12-4.31 2.73A4.74 4.74 0 0 0 7.69 3.75C5.1 3.75 3 5.76 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                    {{ number_format($article->likes) }}
                </button>
            </form>
            @endauth

            <a href="#komentar" class="flex h-11 items-center gap-1.5 rounded-full border border-stone-300 px-3 text-sm dark:border-stone-700" aria-label="Lihat komentar">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.12 2.99 2.7 3.23 1.13.17 2.27.29 3.42.38.35.03.67.21.87.5L12 21l2.75-4.13c.2-.29.52-.47.87-.5 1.15-.09 2.29-.21 3.42-.38 1.58-.24 2.7-1.63 2.7-3.23V6.74c0-1.6-1.12-3-2.7-3.23A48.4 48.4 0 0 0 12 3c-2.39 0-4.74.18-7.04.51C3.37 3.74 2.25 5.14 2.25 6.74v6.02z" /></svg>
                {{ $jumlahKomentar }}
            </a>

            <button type="button" @click="bagikan()" class="ml-auto flex h-11 flex-1 items-center justify-center gap-2 rounded-full bg-green-600 px-4 text-sm font-semibold text-white active:bg-green-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.2 10.9a2.25 2.25 0 1 0 0 2.2m0-2.2c.18.32.28.7.28 1.1s-.1.77-.28 1.1m0-2.2 9.57-5.3m-9.57 7.5 9.57 5.3m0 0a2.25 2.25 0 1 0 3.94 2.2 2.25 2.25 0 0 0-3.94-2.2zm0-12.8a2.25 2.25 0 1 0 3.93-2.2 2.25 2.25 0 0 0-3.93 2.2z" /></svg>
                Bagikan
            </button>
        </div>
    </div>
    @endif

    {{-- Notifikasi tautan tersalin --}}
    <div x-show="tersalin" x-cloak x-transition.opacity class="fixed bottom-24 left-1/2 z-[75] -translate-x-1/2 rounded-full bg-stone-900 px-4 py-2 text-sm text-white shadow-lg lg:bottom-6" role="status">
        Tautan berhasil disalin
    </div>

    {{-- Modal: perlu login untuk menyukai --}}
    <div x-show="loginOpen" x-cloak x-transition.opacity class="fixed inset-0 z-[80] flex items-end justify-center bg-black/50 p-4 sm:items-center" @click.self="loginOpen = false" @keydown.escape.window="loginOpen = false">
        <div class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl dark:bg-stone-900">
            <p class="font-serif text-xl font-bold">Masuk untuk menyukai</p>
            <p class="mt-2 text-sm text-stone-600 dark:text-stone-300">Anda perlu masuk ke akun untuk menyukai berita ini.</p>
            <div class="mt-5 flex gap-2">
                <button type="button" @click="loginOpen = false" class="h-11 flex-1 rounded-full border border-stone-300 text-sm dark:border-stone-700">Nanti saja</button>
                <a href="{{ route('login') }}" class="flex h-11 flex-1 items-center justify-center rounded-full bg-silet-red text-sm font-semibold text-white hover:bg-red-700">Masuk</a>
            </div>
        </div>
    </div>
</div>

<script>
    function artikelPage(judul, url) {
        return {
            progress: 0,
            indeks: 1,
            ukuran: [1, 1.125, 1.25, 1.375],
            tersalin: false,
            loginOpen: false,
            init() {
                try {
                    const simpan = parseInt(localStorage.getItem('ukuranHuruf'), 10);
                    if (!isNaN(simpan) && simpan >= 0 && simpan < this.ukuran.length) this.indeks = simpan;
                } catch (e) {}
                document.body.classList.add('has-bottom-bar');
                this.hitungProgress();
            },
            hitungProgress() {
                const el = this.$refs.body;
                if (!el) return;
                const r = el.getBoundingClientRect();
                const total = r.height - window.innerHeight * 0.5;
                this.progress = total <= 0 ? 100 : Math.max(0, Math.min(100, (-r.top + window.innerHeight * 0.3) / total * 100));
            },
            ubahUkuran(arah) {
                this.indeks = Math.max(0, Math.min(this.ukuran.length - 1, this.indeks + arah));
                try { localStorage.setItem('ukuranHuruf', this.indeks); } catch (e) {}
            },
            async salin() {
                try {
                    await navigator.clipboard.writeText(url);
                    this.tersalin = true;
                    setTimeout(() => this.tersalin = false, 2000);
                } catch (e) {
                    window.prompt('Salin tautan berikut:', url);
                }
            },
            async bagikan() {
                if (navigator.share) {
                    try { await navigator.share({ title: judul, url: url }); } catch (e) {}
                } else {
                    this.salin();
                }
            }
        };
    }
</script>
@endsection
