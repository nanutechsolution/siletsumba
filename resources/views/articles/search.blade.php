@extends('welcome')
@section('content')
<!-- Breadcrumb -->
<div class="bg-silet-gray dark:bg-gray-800 py-2">
    <div class="container mx-auto px-4">
        <nav class="text-sm text-gray-600 dark:text-gray-400">
            <a href="/" class="hover:text-silet-red">Beranda</a> &gt;
            <span class="text-silet-red">Hasil Pencarian</span>
        </nav>
    </div>
</div>
<div class="mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-3 space-y-6">
        <!-- Search Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Hasil Pencarian</h1>
            <!-- Search Form -->
            <form action="{{ route('articles.search') }}" method="GET" class="mb-6">
                <div class="relative">
                    <input type="text" name="q" value="{{ $query }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-silet-red focus:border-transparent dark:bg-gray-700 dark:text-white pr-12" placeholder="Cari berita...">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-silet-red text-white p-2 rounded-lg hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                        </svg>

                    </button>
                </div>
            </form>

            <!-- Search Info -->
            <div class="flex flex-wrap items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                <span>Menampilkan {{ $articles->total() }} hasil untuk "{{ $query }}"</span>
                <span>Waktu pencarian: {{ $searchTime }} detik</span>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-4 mt-4">
                <select name="sort" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Urutkan: Relevansi</option>
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>

                <select name="category" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>

                <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <option>Semua Waktu</option>
                    <option>24 Jam Terakhir</option>
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
        </div>

        <!-- Search Results -->
        <div class="space-y-6">
            @forelse ($articles as $item)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/4">
                        @if ($item->hasMedia('images'))
                        @php
                        $media = $item->getFirstMedia('images');
                        @endphp
                        <img src="{{ $media->getUrl('thumb') }}" srcset="{{ $media->getSrcset('thumb') }}" sizes="300px" alt="{{ $item->name ?? 'Image' }}" loading="lazy" width="400" height="225" class="w-full h-full object-contain object-center" />
                        @else
                        <img src="https://via.placeholder.com/100x80" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-contain" />
                        @endif
                    </div>
                    <div class="md:w-3/4 flex flex-col justify-between">
                        <div>
                            <span class="bg-silet-red text-white px-2 py-1 rounded text-xs font-medium">
                                {{ $item->category->name }}</span>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mt-2 hover:text-silet-red cursor-pointer line-clamp-2">
                                {{ $item->title }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                                {{ Str::limit(strip_tags($item->content), 150) }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mt-3 text-sm text-gray-500 dark:text-gray-400">
                            <span><i class="far fa-clock mr-1"></i> {{ $item->created_at->diffForHumans() }}</span>
                            <span><i class="fas fa-eye mr-1"></i> {{ number_format($item->views) }} kali
                                dilihat</span>
                        </div>

                        <a href="{{ route('articles.show', $item->slug) }}" class="text-silet-red mt-2 font-medium inline-block">Baca selengkapnya</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-600 dark:text-gray-300">Coba gunakan kata kunci yang berbeda atau filter yang
                    lebih spesifik</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Popular Searches -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">PENCARIAN POPULER</h2>
            <div class="space-y-2">
                @foreach ($popularSearches as $item)
                <a href="{{ route('articles.search', ['q' => $item->query]) }}" class="block text-sm text-gray-600 dark:text-gray-300 hover:text-silet-red line-clamp-2">
                    <i class="fas fa-search mr-2 text-xs"></i>{{ $item->query }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Trending Topics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">TRENDING TOPICS</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($trendingTags as $tagName => $count)
                <a href="{{ route('tags.show', $tagName) }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-silet-red hover:text-white cursor-pointer line-clamp-1">
                    #{{ $tagName }} ({{ $count }})
                </a>
                @endforeach
            </div>
        </div>
        <!-- Recent News -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">Trending</h2>
            <div class="space-y-3">
                @foreach ($trendingArticles as $item)
                <a href="{{ route('articles.show', $item->slug) }}" aria-label="Baca berita trending: {{ $item->title }}" class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="text-sm font-medium text-gray-800 dark:text-white hover:text-silet-red cursor-pointer line-clamp-2">
                        {{ $item->title }}
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
