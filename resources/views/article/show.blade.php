@extends('welcome')

@section('content')
    <div class="container mx-auto px-4 py-8 pt-20">
        <a href="{{ route('home') }}" class="text-blue-500 hover:underline mb-4 inline-block">← Kembali ke Beranda</a>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $article->title }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Kategori: <span class="text-blue-600 font-semibold">{{ $article->category->name }}</span>
            </p>

            {{-- Tampilkan semua gambar artikel --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                @forelse ($article->images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $article->title }}"
                        class="w-full h-auto rounded-lg">
                @empty
                    <img src="https://via.placeholder.com/600x400" alt="Placeholder" class="w-full h-auto rounded-lg">
                @endforelse
            </div>

            <div class="prose max-w-none text-gray-800 dark:text-gray-200">
                {!! $article->content !!}
            </div>

            <hr class="my-8 border-gray-200 dark:border-gray-700">

            {{-- Bagian Komentar --}}
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Komentar</h3>

            {{-- Daftar Komentar --}}
            @forelse ($article->comments->where('status', 'approved') as $comment)
                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <p class="font-bold text-gray-800 dark:text-gray-100">{{ $comment->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    <p class="mt-2 text-gray-700 dark:text-gray-200">{{ $comment->body }}</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Belum ada komentar.</p>
            @endforelse

            <hr class="my-8 border-gray-200 dark:border-gray-700">

            {{-- Form Komentar --}}
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tinggalkan Komentar</h3>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama</label>
                    <input type="text" name="name" id="name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="body" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Isi Komentar</label>
                    <textarea name="body" id="body" rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        required></textarea>
                    @error('body')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Kirim
                    Komentar</button>
            </form>
        </div>
    </div>
@endsection
