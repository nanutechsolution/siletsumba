@extends('welcome')
@section('content')
@php
    $urutan = request('sort') === 'oldest' ? 'oldest' : 'latest';
@endphp

<nav aria-label="Breadcrumb" class="mb-4 text-xs text-stone-500 dark:text-stone-400">
    <a href="{{ url('/') }}" class="hover:text-silet-red">Beranda</a>
    <span aria-hidden="true">/</span>
    <span class="font-medium text-stone-700 dark:text-stone-200">Pencarian</span>
</nav>

<div class="grid gap-10 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <h1 class="font-serif text-3xl font-bold">Pencarian berita</h1>

        {{-- Satu form untuk kata kunci, kategori, dan urutan --}}
        <form action="{{ route('articles.search') }}" method="GET" class="mt-4 space-y-3">
            <div class="relative">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M17 10a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="search" name="q" value="{{ $query }}" placeholder="Ketik kata kunci" autocomplete="off"
                    class="w-full rounded-full border-stone-300 bg-white py-3 pl-12 pr-28 text-base shadow-sm focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100">
                <button type="submit" class="absolute right-1.5 top-1/2 h-9 -translate-y-1/2 rounded-full bg-silet-red px-5 text-sm font-semibold text-white hover:bg-red-700">Cari</button>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <select name="category" onchange="this.form.submit()" aria-label="Filter kategori"
                    class="rounded-lg border-stone-300 bg-white py-2.5 text-sm focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('category') == $cat->slug)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="sort" onchange="this.form.submit()" aria-label="Urutkan hasil"
                    class="rounded-lg border-stone-300 bg-white py-2.5 text-sm focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100">
                    <option value="latest" @selected($urutan === 'latest')>Terbaru</option>
                    <option value="oldest" @selected($urutan === 'oldest')>Terlama</option>
                </select>
            </div>
        </form>

        <p class="mt-4 text-sm text-stone-500 dark:text-stone-400">
            @if ($query)
            {{ number_format($articles->total()) }} hasil untuk “{{ $query }}”
            @else
            {{ number_format($articles->total()) }} berita
            @endif
            · {{ $searchTime }} detik
        </p>

        {{-- Hasil --}}
        <div class="mt-2 divide-y divide-stone-200 dark:divide-stone-800">
            @forelse ($articles as $item)
            <article>
                <a href="{{ route('articles.show', $item->slug) }}" class="group flex gap-4 py-5">
                    <div class="img-placeholder h-24 w-32 flex-shrink-0 overflow-hidden rounded-lg sm:h-28 sm:w-44">
                        @if ($item->hasMedia('images'))
                        @php $media = $item->getFirstMedia('images'); @endphp
                        <img src="{{ $media->getUrl('thumb') }}" srcset="{{ $media->getSrcset('thumb') }}" sizes="(max-width: 640px) 128px, 176px"
                            alt="{{ strip_tags($item->title) }}" loading="lazy" width="176" height="112"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]">
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-stone-600 dark:text-stone-300">
                            <span class="h-2 w-2 rounded-sm" style="background-color: {{ $item->category->color ?? '#E41E2D' }}"></span>
                            {{ $item->category->name ?? 'Umum' }}
                        </span>
                        <h2 class="mt-1 line-clamp-3 font-serif text-lg font-bold leading-snug sm:text-xl"><span class="headline-link">{{ strip_tags($item->title) }}</span></h2>
                        <p class="mt-1.5 hidden text-sm leading-relaxed text-stone-600 dark:text-stone-300 sm:block">
                            <span class="line-clamp-2">{{ $item->excerpt ?: Str::limit(strip_tags($item->content), 150) }}</span>
                        </p>
                        <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">
                            {{ ($item->scheduled_at ?? $item->created_at)->diffForHumans() }} · {{ number_format($item->views) }} dibaca
                        </p>
                    </div>
                </a>
            </article>
            @empty
            <div class="py-12 text-center">
                <p class="font-serif text-xl font-bold">Tidak ada hasil ditemukan</p>
                <p class="mx-auto mt-2 max-w-sm text-sm text-stone-600 dark:text-stone-300">Coba kata kunci yang lebih umum atau ganti filter kategori.</p>
                @if ($popularSearches->isNotEmpty())
                <div class="mt-5 flex flex-wrap justify-center gap-2">
                    @foreach ($popularSearches as $item)
                    <a href="{{ route('articles.search', ['q' => $item->query]) }}" class="rounded-full bg-stone-200 px-3 py-1.5 text-sm hover:bg-silet-red hover:text-white dark:bg-stone-800">{{ $item->query }}</a>
                    @endforeach
                </div>
                @endif
            </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $articles->links() }}</div>
    </div>

    <aside class="space-y-10 lg:col-span-4">
        @if ($popularSearches->isNotEmpty())
        <section>
            <div class="border-t-2 border-silet-red pt-3">
                <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Pencarian populer</h2>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($popularSearches as $item)
                <a href="{{ route('articles.search', ['q' => $item->query]) }}" class="rounded-full bg-stone-200 px-3 py-1.5 text-sm hover:bg-silet-red hover:text-white dark:bg-stone-800">{{ $item->query }}</a>
                @endforeach
            </div>
        </section>
        @endif

        @if ($trendingTags->isNotEmpty())
        <section>
            <div class="border-t-2 border-stone-900 pt-3 dark:border-stone-100">
                <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Topik hangat</h2>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($trendingTags as $tagName => $count)
                <a href="{{ route('tags.show', Str::slug($tagName)) }}" class="rounded-full bg-stone-200 px-3 py-1.5 text-sm hover:bg-silet-red hover:text-white dark:bg-stone-800">#{{ $tagName }}</a>
                @endforeach
            </div>
        </section>
        @endif

        <section>
            <div class="border-t-2 border-silet-red pt-3">
                <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Terpopuler bulan ini</h2>
            </div>
            <ol class="divide-y divide-stone-200 dark:divide-stone-800">
                @foreach ($trendingArticles as $index => $item)
                <li>
                    <a href="{{ route('articles.show', $item->slug) }}" class="flex gap-4 py-3.5">
                        <span class="w-7 flex-shrink-0 font-serif text-2xl font-bold leading-none text-sumba-gold">{{ $index + 1 }}</span>
                        <span class="line-clamp-3 font-serif text-base font-semibold leading-snug">{{ strip_tags($item->title) }}</span>
                    </a>
                </li>
                @endforeach
            </ol>
        </section>
    </aside>
</div>
@endsection
