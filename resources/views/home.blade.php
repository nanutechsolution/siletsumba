@extends('welcome')
@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">

        {{-- Hero Section --}}
        @if ($hero)
        <div class="relative w-full aspect-[4/3] md:aspect-[16/9] rounded-lg overflow-hidden shadow-md bg-gray-200">
            <a href="{{ route('articles.show', $hero->slug) }}" aria-label="Baca berita: {{ $hero->title }}" class="block w-full h-full">
                {{-- Hero Image --}}
                @if ($hero->hasMedia('images'))
                <img src="{{ $hero->getFirstMedia('images')->getUrl('responsive') }}" class="w-full h-full object-contain object-center" loading="eager" fetchpriority="high" decoding="async" srcset="{{ $hero->getFirstMedia('images')->getSrcset('responsive') }}" sizes="(max-width: 640px) 100vw, (max-width: 1024px) 80vw, 1200px" alt="{{ $hero->title }}">
                @endif
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent flex flex-col justify-end p-2 sm:p-4">

                    {{-- Konten hero --}}
                    <div class="p-6 text-white">
                        <span class="inline-block text-xs font-semibold px-2 py-1 rounded mb-3" style="background-color: {{ $hero->category->color ?? '#FF0000' }};">
                            {{ $hero->category->name ?? 'Umum' }}
                        </span>

                        <h2 class="text-base sm:text-lg md:text-2xl font-bold line-clamp-2">
                            {{ $hero->title }}
                        </h2>

                        <div class="flex flex-col sm:flex-row sm:items-center text-gray-300 text-xs mt-2 gap-1 sm:gap-2">
                            <span class="flex items-center">
                                @if ($hero->user?->hasMedia('profile_photos'))
                                <img src="{{ $hero->user->getFirstMediaUrl('profile_photos', 'small') }}" alt="{{ $hero->user->name }}" class="w-5 h-5 rounded-full mr-2 object-contain">
                                @else
                                <i class="fas fa-user mr-2 text-gray-300"></i>
                                @endif
                                {{ $hero->user->name ?? 'Penulis' }}
                            </span>

                            <span class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $hero->scheduled_at ? $hero->scheduled_at->diffForHumans() : $hero->created_at->diffForHumans() }}
                            </span>

                        </div>
                    </div>

                </div>
            </a>
        </div>
        @endif

        {{-- ✅ Tambahkan iklan di sini --}}
        {{-- <div class="my-6 text-center">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1183290597740176" crossorigin="anonymous"></script>
            <!-- display_home_top -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});

            </script>
        </div> --}}
        {{-- ✅ Akhir iklan --}}

        {{-- Latest Articles Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
            @foreach ($latestArticles as $article)
            <a href="{{ route('articles.show', $article->slug) }}" aria-label="Baca berita: {{ $article->title }}" class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                {{-- Image wrapper --}}
                <div class="relative w-full aspect-[16/9] bg-gray-200 dark:bg-gray-700">
                    @if ($article->hasMedia('images'))
                    @php $media = $article->getFirstMedia('images'); @endphp
                    <img src="{{ $media->getUrl('thumb') }}" srcset="{{ $media->getSrcset('thumb') }}" sizes="300px" alt="{{ $article->name ?? 'Hero Image' }}" loading="lazy" width="400" height="225" class="w-full h-full object-contain object-center" />
                    @endif
                    {{-- <span class="absolute top-2 left-2 text-xs px-2 py-1 rounded font-semibold text-white" style="background-color: {{ $article->category->color ?? '#FF0000' }}">
                    {{ $article->category->name ?? 'Umum' }}
                    </span> --}}
                </div>

                {{-- Konten berita --}}
                <div class="p-3 md:p-4 flex flex-col justify-start min-h-[180px] bg-white dark:bg-gray-800 rounded shadow dark:shadow-lg transition-colors duration-300">
                    <div class="font-bold text-base md:text-lg text-gray-800 dark:text-white line-clamp-3 leading-6 mb-1">
                        {{ $article->title }}
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 leading-6 mb-2">
                        {{ strip_tags($article->content) }}
                    </p>
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ $article->scheduled_at ? $article->scheduled_at->diffForHumans() : $article->created_at->diffForHumans() }}
                        </span>
                        @auth
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            {{ number_format($article->views) }} dibaca
                        </span>
                        @endauth

                    </div>
                </div>
            </a>
            {{-- 🔸 Iklan di tengah daftar berita --}}
            @if ($loop->iteration == 3 || $loop->iteration == 6)
            <div class="col-span-full my-6 text-center">
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});

                </script>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $latestArticles->links() }}
        </div>
        {{-- 🔹 Iklan bawah halaman --}}
        {{-- <div class="mt-8 text-center">
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});

            </script>
        </div> --}}
    </div>

    {{-- Sidebar (1/3) --}}
    <aside class="space-y-6 lg:col-span-1">
        {{-- Trending News --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <h2 class="font-bold text-lg mb-4 text-red-600 border-b pb-2">
                <i class="fas fa-fire mr-2"></i> TRENDING
            </h2>
            <div class="space-y-3">
                @foreach ($trending as $index => $article)
                <a href="{{ route('articles.show', $article->slug) }}" aria-label="Baca berita trending: {{ $article->title }}" class="flex items-start space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition">
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
        {{-- 🔹 Iklan di sidebar --}}
        {{-- <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-3 text-center">
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1183290597740176" data-ad-slot="4322923461" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});

            </script>
        </div> --}}

        {{-- Latest News --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <h2 class="font-bold text-lg mb-4 text-red-600 border-b pb-2">
                <i class="fas fa-clock mr-2"></i> TERBARU
            </h2>
            <div class="space-y-4">
                @foreach ($latestFive as $article)
                <a href="{{ route('articles.show', $article->slug) }}" aria-label="Baca berita terbaru: {{ $article->title }}" class="flex space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition-colors">

                    <div class="w-20 aspect-[5/4] flex-shrink-0 overflow-hidden rounded">
                        @if ($article->hasMedia('images'))
                        @php
                        $media = $article->getFirstMedia('images');
                        @endphp
                        <img src="{{ $media->getUrl('thumb') }}" srcset="{{ $media->getSrcset('thumb') }}" sizes="80px" width="100" height="80" alt="{{ $article->name ?? 'Hero Image' }}" loading="lazy" class="w-full h-full object-contain object-center" />
                        @else
                        <img src="https://via.placeholder.com/100x80" alt="{{ $article->title }}" loading="lazy" class="w-full h-full object-contain" />
                        @endif
                    </div>


                    <div class="flex-1">
                        <h3 class="font-medium text-sm hover:text-red-600 cursor-pointer line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        <p class="text-xs text-gray-500">{{ $article->scheduled_at->diffForHumans() }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </aside>

</div>
@endsection
