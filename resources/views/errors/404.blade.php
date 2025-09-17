@extends('welcome')

@section('content')
    <div class="min-h-[80vh] flex flex-col items-center justify-center text-center px-4 relative">

        {{-- Ilustrasi Animasi 404 --}}
        <div class="w-64 md:w-96 mb-6 relative">
            <img src="{{ asset('images/404-character.png') }}" alt="404 Not Found" class="w-full animate-bounce-slow">
        </div>
        {{-- Judul --}}
        <h1 class="text-5xl font-extrabold text-red-600 mb-2">404</h1>
        <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 mb-6">
            Maaf, halaman yang kamu cari tidak ditemukan.
        </p>

        {{-- Tombol Navigasi --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ url('/') }}"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded shadow transition">
                Kembali ke Beranda
            </a>
            <a href="{{ route('home') }}"
                class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold px-6 py-3 rounded shadow transition">
                Lihat Semua Berita
            </a>
        </div>

        {{-- Trending / Popular Articles --}}
        @if (!empty($trending) && $trending->count())
            <div class="w-full max-w-5xl">
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Artikel Berita</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($trending as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative aspect-[16/9]">
                                <img src="{{ $article->image_url ?? 'https://via.placeholder.com/300x200' }}"
                                    alt="{{ $article->title }}"
                                    class="w-full h-full object-cover group-hover:brightness-90 transition duration-300">
                                <span class="absolute top-2 left-2 text-white text-xs px-2 py-1 rounded font-semibold"
                                    style="background-color: {{ $article->category->color ?? '#FF0000' }};">
                                    {{ $article->category->name ?? 'Umum' }}
                                </span>
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-sm line-clamp-2 group-hover:text-red-600 transition">
                                    {{ $article->title }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Animasi tambahan --}}
    <style>
        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
    </style>
@endsection
