@extends('welcome')

@section('content')
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content (2/3) --}}
        <main class="lg:col-span-2 space-y-6">

            {{-- Featured Hero Article --}}
            @if ($hero)
                <div class="relative h-[50vh] rounded-lg overflow-hidden shadow-md">
                    <a href="{{ route('articles.show', $hero->slug) }}" class="block group">
                        <img src="{{ $hero->image_url ?? 'https://via.placeholder.com/800x400' }}" alt="{{ $hero->title }}"
                            class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">

                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 backdrop-blur-sm p-6">
                            <span class="text-xs font-medium px-2 py-1 rounded"
                                style="background-color: {{ $hero->category->color ?? '#FF0000' }};">
                                {{ $hero->category->name ?? 'Umum' }}
                            </span>
                            <h2 class="text-3xl font-bold text-white mt-2 line-clamp-2">{{ $hero->title }}</h2>
                            <p class="text-white mt-2 line-clamp-3">{{ Str::limit(strip_tags($hero->content), 100) }}</p>
                            <div class="flex items-center text-gray-300 text-sm mt-3">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach ($latestArticles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}"
                        class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">

                        {{-- Image --}}
                        <div class="relative h-48">
                            <img src="{{ $article->image_url ?? 'https://via.placeholder.com/300x200' }}"
                                alt="{{ $article->title }}"
                                class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">
                            <span class="absolute top-2 left-2 text-white text-xs px-2 py-1 rounded font-semibold"
                                style="background-color: {{ $article->category->color ?? '#FF0000' }};">
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
                                {{ Str::limit(strip_tags($article->content), 120) }}
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
        <aside class="space-y-6 sticky top-24 hidden lg:block">

            {{-- Trending News --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="font-bold text-lg mb-4 text-red-600 border-b pb-2">
                    <i class="fas fa-fire mr-2"></i> TRENDING
                </h3>
                <div class="space-y-3">
                    @foreach ($trending as $index => $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="flex items-start space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition">
                            <span class="bg-red-600 text-white text-xs px-2 py-1 rounded mt-1">{{ $index + 1 }}</span>
                            <div>
                                <h4 class="font-medium hover:text-red-600 cursor-pointer line-clamp-2">
                                    {{ $article->title }}</h4>
                                <p class="text-xs text-gray-500">{{ number_format($article->views) }} dibaca</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Latest News --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="font-bold text-lg mb-4 text-red-600 border-b pb-2">
                    <i class="fas fa-clock mr-2"></i> TERBARU
                </h3>
                <div class="space-y-4">
                    @foreach ($latestArticles->take(5) as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="flex space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition-colors">
                            @if ($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}"
                                    class="w-20 h-15 object-cover rounded">
                            @endif
                            <div>
                                <h4 class="font-medium text-sm hover:text-red-600 cursor-pointer line-clamp-2">
                                    {{ $article->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </aside>
    </div>
@endsection
