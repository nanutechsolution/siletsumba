@extends('welcome')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Hero Featured Article --}}
        @if ($hero)
            <div class="relative w-full aspect-video rounded-lg overflow-hidden shadow-md bg-gray-200 animate-pulse">
                <a href="{{ route('articles.show', $hero->slug) }}" class="block group">
                    <img src="{{ $hero->getFirstMediaUrl('images', 'thumb') }}"
                        data-src="{{ $hero->getFirstMediaUrl('images') }}" alt="{{ $hero->title }}"
                        class="w-full h-full object-cover blur-sm transition duration-500 ease-in-out lazyload" loading="lazy"
                        width="800" height="450">
                    {{-- Overlay --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent p-4 flex flex-col justify-end">
                        <span class="text-xs font-medium px-2 py-1 rounded text-white"
                            style="background-color: {{ $hero->category->color ?? '#FF0000' }};">
                            {{ $hero->category->name ?? 'Umum' }}
                        </span>
                        <h2 class="text-lg md:text-3xl font-bold text-white mt-2 line-clamp-2">
                            {{ $hero->title }}
                        </h2>
                        <div class="flex items-center text-gray-300 text-xs mt-2">
                            <span class="flex items-center">
                                @if ($hero->user?->hasMedia('profile_photos'))
                                    <img src="{{ $hero->user->getFirstMediaUrl('profile_photos', 'small') }}"
                                        alt="{{ $hero->user->name }}" class="w-5 h-5 rounded-full mr-1 object-cover">
                                @else
                                    <i class="fas fa-user mr-1 text-gray-400"></i>
                                @endif
                                {{ $hero->user->name ?? 'Penulis' }}
                            </span>
                            <span class="mx-2">•</span>
                            <span><i class="fas fa-clock mr-1"></i> {{ $hero->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        {{-- Main + Sidebar --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Content --}}
            <main class="lg:col-span-2 space-y-6">

                {{-- Latest Articles Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($latestArticles as $article)
                        @php
                            $bgColor = $article->category->color ?? '#FF0000';
                            $textColor = (function ($hex) {
                                $hex = str_replace('#', '', $hex);
                                $r = hexdec(substr($hex, 0, 2));
                                $g = hexdec(substr($hex, 2, 2));
                                $b = hexdec(substr($hex, 4, 2));
                                return (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255 > 0.5 ? '#000' : '#fff';
                            })($bgColor);
                        @endphp
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">

                            {{-- Image skeleton + lazy --}}
                            <div class="relative w-full aspect-[16/9] bg-gray-200 dark:bg-gray-700 animate-pulse">
                                @if ($article->hasMedia('images'))
                                    <img src="{{ $article->getFirstMediaUrl('images', 'thumb') }}"
                                        data-src="{{ $article->getFirstMediaUrl('images') }}" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover blur-sm transition duration-500 lazyload"
                                        loading="lazy">
                                @else
                                    <img src="https://via.placeholder.com/400x225" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover">
                                @endif
                                <span class="absolute top-2 left-2 text-xs px-2 py-1 rounded font-semibold"
                                    style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                                    {{ $article->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            {{-- Content --}}
                            <div class="p-3 md:p-4 flex flex-col justify-between min-h-[140px]">
                                <h3 class="font-bold text-base md:text-lg text-gray-800 dark:text-white line-clamp-2 mb-1">
                                    {{ $article->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-2">
                                    {{ strip_tags($article->content) }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center"><i
                                            class="far fa-clock mr-1"></i>{{ $article->created_at->diffForHumans() }}</span>
                                    <span class="flex items-center"><i
                                            class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} dibaca</span>
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

            {{-- Sidebar --}}
            <aside class="space-y-6">

                {{-- Trending --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <h2 class="font-bold text-lg mb-4 text-red-600 border-b pb-2"><i class="fas fa-fire mr-2"></i>TRENDING
                    </h2>
                    <div class="space-y-3">
                        @foreach ($trending as $i => $article)
                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="flex items-start space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition">
                                <span
                                    class="bg-red-600 text-white text-xs px-2 py-1 rounded mt-1">{{ $i + 1 }}</span>
                                <div>
                                    <h3 class="font-medium hover:text-red-600 line-clamp-2">{{ $article->title }}</h3>
                                    <p class="text-xs text-gray-500">{{ number_format($article->views) }} dibaca</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Latest 5 --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <h2 class="font-bold text-lg mb-4 text-red-600 border-b pb-2"><i class="fas fa-clock mr-2"></i>TERBARU
                    </h2>
                    <div class="space-y-4">
                        @foreach ($latestFive as $article)
                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="flex space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition">
                                <div class="w-20 aspect-[5/4] flex-shrink-0 overflow-hidden rounded">
                                    @if ($article->hasMedia('images'))
                                        <img src="{{ $article->getFirstMediaUrl('images', 'thumb') }}"
                                            data-src="{{ $article->getFirstMediaUrl('images') }}" loading="lazy"
                                            class="w-full h-full object-cover lazyload">
                                    @else
                                        <img src="https://via.placeholder.com/100x80" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-sm hover:text-red-600 line-clamp-2">{{ $article->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>

    </div>

    {{-- LazySizes JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
@endsection
