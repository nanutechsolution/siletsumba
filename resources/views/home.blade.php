@extends('welcome')
@section('content')
@php
    $waktu = fn ($a) => ($a->scheduled_at ?? $a->created_at)->diffForHumans();
    $ringkas = fn ($a, $n = 150) => $a->excerpt ?: Str::limit(strip_tags($a->content), $n);
@endphp

{{-- Judul halaman kategori (dipakai saat route kategori memakai view ini) --}}
@isset($category)
<div class="mb-6 border-b-2 border-stone-900 pb-3 dark:border-stone-100">
    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Kategori</p>
    <h1 class="font-serif text-3xl font-bold">{{ $category->name }}</h1>
</div>
@endisset

@if (!$hero)
<div class="rounded-lg border border-dashed border-stone-300 p-10 text-center text-stone-500 dark:border-stone-700">
    Belum ada berita yang terbit.
</div>
@else

{{-- ===== Baris 1: berita utama + terbaru ===== --}}
<section class="grid gap-8 lg:grid-cols-12">
    <article class="lg:col-span-8">
        <a href="{{ route('articles.show', $hero->slug) }}" class="group block" aria-label="Baca berita: {{ $hero->title }}">
            <div class="img-placeholder relative aspect-[16/10] overflow-hidden rounded-lg">
                @if ($hero->hasMedia('images'))
                @php $heroMedia = $hero->getFirstMedia('images'); @endphp
                <img src="{{ $heroMedia->getUrl('responsive') }}" srcset="{{ $heroMedia->getSrcset('responsive') }}"
                    sizes="(max-width: 1024px) 100vw, 800px" alt="{{ $hero->title }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
                    loading="eager" fetchpriority="high" decoding="async">
                @endif
            </div>
            <div class="mt-4">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-stone-600 dark:text-stone-300">
                    <span class="h-2 w-2 rounded-sm" style="background-color: {{ $hero->category->color ?? '#E41E2D' }}"></span>
                    {{ $hero->category->name ?? 'Umum' }}
                </span>
                <h2 class="mt-2 font-serif text-2xl font-bold leading-tight sm:text-3xl lg:text-4xl">
                    <span class="headline-link">{{ $hero->title }}</span>
                </h2>
                <div class="hidden sm:block">
                    <p class="mt-3 line-clamp-3 text-base leading-relaxed text-stone-600 dark:text-stone-300">
                        {{ $ringkas($hero, 220) }}
                    </p>
                </div>
                <p class="mt-3 text-xs text-stone-500 dark:text-stone-400">
                    @if ($hero->user?->name)<span class="font-medium text-stone-700 dark:text-stone-200">{{ $hero->user->name }}</span> · @endif
                    {{ $waktu($hero) }}
                </p>
            </div>
        </a>
    </article>

    <aside class="lg:col-span-4">
        <div class="border-t-2 border-silet-red pt-3">
            <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Terbaru</h2>
        </div>
        <div class="divide-y divide-stone-200 dark:divide-stone-800">
            @foreach ($latestFive as $article)
            <a href="{{ route('articles.show', $article->slug) }}" aria-label="Baca berita: {{ $article->title }}" class="group flex gap-3 py-4">
                <div class="img-placeholder h-16 w-24 flex-shrink-0 overflow-hidden rounded">
                    @if ($article->hasMedia('images'))
                    @php $m = $article->getFirstMedia('images'); @endphp
                    <img src="{{ $m->getUrl('thumb') }}" srcset="{{ $m->getSrcset('thumb') }}" sizes="96px" width="96" height="64"
                        alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-stone-500 dark:text-stone-400">{{ $article->category->name ?? 'Umum' }}</p>
                    <h3 class="mt-0.5 line-clamp-2 font-serif text-base font-semibold leading-snug"><span class="headline-link">{{ $article->title }}</span></h3>
                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">{{ $waktu($article) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </aside>
</section>
@endif

{{-- ===== Baris 2: daftar berita + terpopuler ===== --}}
<section class="mt-12 grid gap-8 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <div class="border-t-2 border-stone-900 pt-3 dark:border-stone-100">
            <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Berita lainnya</h2>
        </div>

        <div class="mt-5 grid gap-x-6 gap-y-8 sm:grid-cols-2">
            @foreach ($latestArticles as $article)
            <article>
                <a href="{{ route('articles.show', $article->slug) }}" class="group block" aria-label="Baca berita: {{ $article->title }}">
                    <div class="img-placeholder aspect-[16/10] overflow-hidden rounded-lg">
                        @if ($article->hasMedia('images'))
                        @php $media = $article->getFirstMedia('images'); @endphp
                        <img src="{{ $media->getUrl('responsive') }}" srcset="{{ $media->getSrcset('responsive') }}" sizes="(max-width: 640px) 100vw, 380px"
                            alt="{{ $article->title }}" loading="lazy" width="400" height="250"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                        @endif
                    </div>
                    <span class="mt-3 inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-stone-600 dark:text-stone-300">
                        <span class="h-2 w-2 rounded-sm" style="background-color: {{ $article->category->color ?? '#E41E2D' }}"></span>
                        {{ $article->category->name ?? 'Umum' }}
                    </span>
                    <h3 class="mt-1 line-clamp-3 font-serif text-xl font-bold leading-snug"><span class="headline-link">{{ $article->title }}</span></h3>
                    <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-stone-600 dark:text-stone-300">{{ $ringkas($article) }}</p>
                    <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">{{ $waktu($article) }}</p>
                </a>
            </article>

            {{-- Slot iklan di sela daftar --}}
            @if ($loop->iteration == 3 || $loop->iteration == 6)
            <div class="col-span-full text-center">
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
            @endif
            @endforeach
        </div>

        <div class="mt-8">{{ $latestArticles->links() }}</div>
    </div>

    <aside class="lg:col-span-4">
        <div class="lg:sticky lg:top-20">
            <div class="border-t-2 border-silet-red pt-3">
                <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Terpopuler</h2>
            </div>
            <ol class="divide-y divide-stone-200 dark:divide-stone-800">
                @foreach ($trending as $index => $article)
                <li>
                    <a href="{{ route('articles.show', $article->slug) }}" aria-label="Baca berita populer: {{ $article->title }}" class="group flex gap-4 py-4">
                        <span class="w-8 flex-shrink-0 font-serif text-3xl font-bold leading-none text-sumba-gold">{{ $index + 1 }}</span>
                        <div class="min-w-0">
                            <h3 class="line-clamp-3 font-serif text-base font-semibold leading-snug"><span class="headline-link">{{ $article->title }}</span></h3>
                            <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">{{ number_format($article->views) }} dibaca</p>
                        </div>
                    </a>
                </li>
                @endforeach
            </ol>

            {{-- Slot iklan sidebar (aktifkan bila perlu) --}}
            {{-- <div class="mt-6 text-center">
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div> --}}
        </div>
    </aside>
</section>
@endsection
