@extends('welcome')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-tribun-gray dark:bg-gray-800 py-2">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-600 dark:text-gray-400">
                <a href="/" class="hover:text-tribun-red">Home</a> >
                <span class="text-tribun-red">Hasil Pencarian</span>
            </nav>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Search Results (3/4) -->
        <div class="lg:col-span-3">
            <!-- Search Header -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Hasil Pencarian</h1>
                <!-- Search Bar -->
                <form action="{{ route('articles.search') }}" method="GET">
                    <div class="relative mb-6">
                        <input type="text" name="q" value="{{ $query }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-tribun-red focus:border-transparent dark:bg-gray-700 dark:text-white pr-12"
                            placeholder="Cari berita...">
                        <button type="submit"
                            class="absolute right-2 top-2 bg-tribun-red text-white p-2 rounded-lg hover:bg-red-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <!-- Search Info -->
                <div class="flex flex-wrap items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span>Menampilkan {{ $articles->total() }} hasil untuk "{{ $query }}"</span>
                    <span>Waktu pencarian: {{ $searchTime }} detik</span>
                </div>
                <!-- Filter Options -->
                <div class="flex flex-wrap gap-4 mt-4">
                    <select name="sort"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">Urutkan: Relevansi</option>
                        <option value="latest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                    <select name="category"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <select
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option>Semua Waktu</option>
                        <option>24 Jam Terakhir</option>
                        <option>Minggu Ini</option>
                        <option>Bulan Ini</option>
                    </select>
                </div>
            </div>
            <!-- Search Results -->
            <div class="space-y-6">
                <!-- Result 1 -->
                @foreach ($articles as $item)
                    <div class="search-result-card bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/4">
                                <img src="{{ $item->image ? Storage::url($item->image) : 'https://images.unsplash.com/photo-1572947650440-e8a97ef053b2?w=300&h=200&fit=crop' }}"
                                    alt="Presiden Jokowi meresmikan proyek infrastruktur"
                                    class="w-full h-40 object-cover rounded-lg">
                            </div>
                            <div class="md:w-3/4">
                                <span class="bg-tribun-red text-white px-2 py-1 rounded text-xs font-medium">
                                    {{ $item->category->name }}</span>
                                <h2
                                    class="text-xl font-bold text-gray-800 dark:text-white mt-2 hover:text-tribun-red cursor-pointer">
                                    {{ $item->title }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->content), 150) }}
                                </p>
                                <a href="{{ route('articles.show', $item->slug) }}"
                                    class="text-tribun-red mt-1 inline-block font-medium">
                                    Baca selengkapnya
                                </a>

                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-3">
                                    <span><i class="far fa-clock mr-1"></i> {{ $item->created_at->diffForHumans() }}</span>
                                    <span class="mx-2">•</span>
                                    <span><i class="fas fa-eye mr-1"></i> {{ $item->views }} kali dilihat</span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <nav class="flex items-center space-x-2">
                    {{ $articles->links() }}
                </nav>
            </div>

            <!-- No Results (Hidden by default) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hidden">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-600 dark:text-gray-300">Coba gunakan kata kunci yang berbeda atau filter yang
                    lebih spesifik</p>
            </div>
        </div>

        <!-- Sidebar (1/4) -->
        <div class="lg:col-span-1">
            <!-- Popular Searches -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">PENCARIAN POPULER</h2>
                <div class="space-y-2">
                    @foreach ($popularSearches as $item)
                        <a href="{{ route('articles.search', ['q' => $item->query]) }}"
                            class="block text-sm text-gray-600 dark:text-gray-300 hover:text-tribun-red">
                            <i class="fas fa-search mr-2 text-xs"></i>{{ $item->query }}
                        </a>
                    @endforeach
                </div>
            </div>


            <!-- Trending Topics -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">TRENDING TOPICS</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach ($trendingTags as $tagName => $count)
                        <a href="{{ route('tags.show', $tagName) }}"
                            class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-tribun-red hover:text-white cursor-pointer">
                            #{{ $tagName }} ({{ $count }})
                        </a>
                    @endforeach
                </div>
            </div>


            <!-- Advertisement -->
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 mb-6 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">ADVERTISEMENT</p>
                <div class="bg-white dark:bg-gray-600 p-4 rounded">
                    <img src="https://via.placeholder.com/300x250" alt="Iklan" class="mx-auto rounded">
                    <p class="text-sm mt-2 text-gray-600 dark:text-gray-300">Sponsored Content</p>
                </div>
            </div>

            <!-- Recent News -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">BERITA TERBARU</h2>
                <div class="space-y-3">
                    @foreach ($trendingArticles as $item)
                        <div class="text-sm font-medium text-gray-800 dark:text-white hover:text-tribun-red cursor-pointer">
                            {{ $item->title }}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
