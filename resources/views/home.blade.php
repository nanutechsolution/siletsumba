@extends('welcome')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Main Content (2/3) --}}
        <main class="lg:col-span-2 space-y-6">
            {{-- Featured Hero Article --}}
            @if ($hero)
                <div class="relative h-[50vh] md:h-[60vh] rounded-lg overflow-hidden shadow-md">
                    <a href="{{ route('articles.show', $hero->slug) }}" class="block group"
                        aria-label="Baca artikel: {{ $hero->title }}">
                        @if ($hero->hasMedia('images'))
                            <picture>
                                <source srcset="{{ $hero->getFirstMedia('images')->getSrcset('webp') }}" type="image/webp">
                                <img srcset="{{ $hero->getFirstMedia('images')->getSrcset() }}"
                                    src="{{ $hero->getFirstMediaUrl('images') }}" alt="{{ $hero->title }}" loading="eager"
                                    fetchpriority="high"
                                    class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">
                            </picture>
                        @else
                            <img src="https://via.placeholder.com/800x400" alt="{{ $hero->title }}" loading="eager"
                                fetchpriority="high"
                                class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">
                        @endif
                        {{-- Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent p-6 flex flex-col justify-end">
                            <span class="text-xs font-medium px-2 py-1 rounded self-start text-white"
                                style="background-color: {{ $hero->category->color ?? '#FF0000' }};"
                                aria-label="Kategori: {{ $hero->category->name ?? 'Umum' }}">
                                {{ $hero->category->name ?? 'Umum' }}
                            </span>


                            <h2 class="text-2xl md:text-3xl font-bold text-white mt-2 line-clamp-2">
                                {{ $hero->title }}
                            </h2>

                            <p class="text-white mt-2 line-clamp-3 text-sm md:text-base">
                                {{ Str::limit(strip_tags($hero->content), 100) }}
                            </p>

                            <div class="flex items-center text-gray-300 text-xs md:text-sm mt-3">
                                <span class="flex items-center">
                                    @if (!empty($hero->user?->profile_photo_path))
                                        <img src="{{ Storage::url($hero->user->profile_photo_path) }}"
                                            alt="{{ $hero->user->name }}" class="w-6 h-6 rounded-full mr-2 object-cover">
                                    @else
                                        <i class="fas fa-user mr-2"></i>
                                    @endif
                                    {{ $hero->user->name ?? 'Penulis' }}
                                </span>
                                <span class="mx-3">•</span>
                                <span><i class="fas fa-clock mr-1"></i> {{ $hero->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            {{-- Latest Articles Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    if (!function_exists('getContrastColor')) {
                        function getContrastColor($hex)
                        {
                            $hex = str_replace('#', '', $hex);
                            $r = hexdec(substr($hex, 0, 2));
                            $g = hexdec(substr($hex, 2, 2));
                            $b = hexdec(substr($hex, 4, 2));
                            $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
                            return $luminance > 0.5 ? '#000000' : '#FFFFFF';
                        }
                    }
                @endphp

                @foreach ($latestArticles as $article)
                    @php
                        // Pastikan bgColor dihitung per artikel
                        $bgColor = $article->category->color ?? '#FF0000';
                        $textColor = getContrastColor($bgColor);
                    @endphp
                    <a href="{{ route('articles.show', $article->slug) }}"
                        aria-label="Baca artikel: {{ $article->title }}"
                        class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                        {{-- Image --}}
                        <div class="relative aspect-[16/9]">
                            @if ($article->hasMedia('images'))
                                <picture>
                                    {{-- WebP --}}
                                    <source srcset="{{ $article->getFirstMedia('images')->getSrcset('webp') }}"
                                        type="image/webp">
                                    {{-- Fallback JPG/PNG --}}
                                    <img srcset="{{ $article->getFirstMedia('images')->getSrcset() }}"
                                        src="{{ $article->getFirstMediaUrl('images') }}" alt="{{ $article->title }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">
                                </picture>
                            @else
                                <img src="https://via.placeholder.com/300x200" alt="{{ $article->title }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">
                            @endif
                            <span class="absolute top-2 left-2 text-xs px-2 py-1 rounded font-semibold"
                                style="background-color: {{ $bgColor }}; color: {{ $textColor }};"
                                aria-label="Kategori: {{ $article->category->name ?? 'Umum' }}">
                                {{ $article->category->name ?? 'Umum' }}
                            </span>
                        </div>
                        {{-- Content --}}
                        <div class="p-4">
                            <h3
                                class="font-bold text-lg mb-2 text-gray-800 dark:text-white line-clamp-2 group-hover:text-red-600 transition">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-3">
                                {{ strip_tags($article->content) }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span><i class="far fa-clock mr-1"></i>{{ $article->created_at->diffForHumans() }}</span>
                                <span><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} dibaca</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            {{-- Pagination --}}
            <div class="mt-6">
                {{ $latestArticles->links() }}
            </div>
        </main>

        {{-- Sidebar (1/3) --}}
        <aside class="space-y-6 lg:col-span-1">

            {{-- Trending News --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="font-bold text-lg mb-4 text-red-600 border-b pb-2">
                    <i class="fas fa-fire mr-2"></i> TRENDING
                </h2>
                <div class="space-y-3">
                    @foreach ($trending as $index => $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            aria-label="Baca artikel trending: {{ $article->title }}"
                            class="flex items-start space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition">
                            <span class="bg-red-600 text-white text-xs px-2 py-1 rounded mt-1">{{ $index + 1 }}</span>
                            <div>
                                <h3 class="font-medium hover:text-red-600 cursor-pointer line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-xs text-gray-500">{{ number_format($article->views) }} dibaca</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Latest News --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="font-bold text-lg mb-4 text-red-600 border-b pb-2">
                    <i class="fas fa-clock mr-2"></i> TERBARU
                </h2>
                <div class="space-y-4">
                    @foreach ($latestFive as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            aria-label="Baca artikel terbaru: {{ $article->title }}"
                            class="flex space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition-colors">
                            @if ($article->hasMedia('images'))
                                <picture>
                                    <source srcset="{{ $article->getFirstMedia('images')->getSrcset('webp') }}"
                                        type="image/webp">
                                    <img srcset="{{ $article->getFirstMedia('images')->getSrcset() }}"
                                        src="{{ $article->getFirstMediaUrl('images') }}" alt="{{ $article->title }}"
                                        loading="lazy" class="w-20 h-15 object-cover rounded">
                                </picture>
                            @else
                                <img src="https://via.placeholder.com/100x80" alt="{{ $article->title }}" loading="lazy"
                                    class="w-20 h-15 object-cover rounded">
                            @endif

                            <div>
                                <h3 class="font-medium text-sm hover:text-red-600 cursor-pointer line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

    </div>
@endsection
