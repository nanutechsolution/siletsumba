@extends('welcome')

@section('content')
    <div class="relative overflow-hidden bg-cover bg-no-repeat p-12 text-center"
        style="background-image: url('https://images.unsplash.com/photo-1558223631-c454e99a712f?q=80&w=1974&auto=format&fit=crop'); height: 500px;">
        <div class="absolute inset-0 bg-black/50 flex flex-col justify-center items-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">
                Jelajahi Keindahan dan Budaya Sumba
            </h1>
            <p class="text-lg sm:text-xl text-white max-w-2xl drop-shadow-lg">
                Silet Sumba menyajikan berita, cerita, dan keunikan Sumba yang akan memukau Anda.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Daftar Berita Terbaru --}}
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6">Berita Populer</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($latestArticles as $article)
                <div
                    class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    {{-- Gambar pertama dari artikel --}}
                    @if ($article->images->count() > 0)
                        <img src="{{ asset('storage/' . $article->images->first()->path) }}" alt="{{ $article->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <img src="https://via.placeholder.com/600x400" alt="Placeholder" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <span
                            class="inline-block bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded-full uppercase mb-2">
                            {{ $article->category->name }}
                        </span>
                        <a href="{{ route('articles.show', $article->slug) }}">
                            <h3
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                                {{ $article->title }}
                            </h3>
                        </a>
                        <p class="text-gray-600 dark:text-gray-300 line-clamp-3">
                            {{ Str::limit(strip_tags($article->content), 150) }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-full">Belum ada berita terbaru.</p>
            @endforelse
        </div>
    </div>
@endsection
