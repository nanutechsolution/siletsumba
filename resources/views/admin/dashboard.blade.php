<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Card --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                @if (Auth::user()->profile_photo_path)
                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}"
                        class="h-16 w-16 object-cover rounded-full flex-shrink-0">
                @else
                    <div
                        class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 flex-shrink-0">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
                <div class="text-center sm:text-left">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Halo, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Selamat datang kembali di panel administrasi Silet
                        Sumba. Mari kelola berita hari ini!</p>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                    class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 border-l-4 border-blue-500 dark:border-blue-400">
                    <h3 class="text-md font-bold text-gray-800 dark:text-white">Total Artikel</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalArticles }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 border-l-4 border-green-500 dark:border-green-400">
                    <h3 class="text-md font-bold text-gray-800 dark:text-white">Total Views</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalViews) }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 border-l-4 border-yellow-500 dark:border-yellow-400">
                    <h3 class="text-md font-bold text-gray-800 dark:text-white">Komentar Pending</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $pendingComments }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 border-l-4 border-red-500 dark:border-red-400">
                    <h3 class="text-md font-bold text-gray-800 dark:text-white">Penulis Aktif</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $activeWriters }}</p>
                </div>
            </div>

            {{-- Recent Articles & Comments --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Recent Articles --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Artikel Terbaru</h3>
                        <a href="{{ route('admin.articles.index') }}"
                            class="text-blue-500 dark:text-blue-400 text-sm">Lihat Semua</a>
                    </div>
                    <ul class="space-y-4">
                        @forelse ($recentArticles as $article)
                            <li
                                class="flex flex-col sm:flex-row sm:items-center justify-between border-b dark:border-gray-700 pb-2 last:border-b-0">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-white truncate">{{ $article->title }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Oleh:
                                        {{ $article->user->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $article->created_at->diffForHumans() }}</p>
                                </div>
                                <span
                                    class="mt-2 sm:mt-0 px-2 py-1 rounded text-xs font-semibold {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $article->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </li>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">Tidak ada artikel terbaru.</p>
                        @endforelse
                    </ul>
                </div>

                {{-- Recent Comments --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Komentar Terbaru</h3>
                        <a href="{{ route('admin.comments.index') }}"
                            class="text-blue-500 dark:text-blue-400 text-sm">Lihat Semua</a>
                    </div>
                    <ul class="space-y-4">
                        @forelse ($recentComments as $comment)
                            <li
                                class="flex flex-col sm:flex-row sm:items-start space-y-2 sm:space-y-0 sm:space-x-3 border-b dark:border-gray-700 pb-2 last:border-b-0">
                                <div
                                    class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $comment->name }}
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400">({{ $comment->created_at->diffForHumans() }})</span>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                        {{ $comment->body }}</p>
                                    <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                        class="text-xs text-blue-500 dark:text-blue-400 hover:underline">Moderasi</a>
                                </div>
                            </li>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">Tidak ada komentar terbaru.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Trending Articles --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Artikel Terpopuler (7 Hari Terakhir)
                    </h3>
                </div>
                <ul class="space-y-4">
                    @forelse ($trendingArticles as $article)
                        <li
                            class="flex flex-col sm:flex-row sm:items-center justify-between border-b dark:border-gray-700 pb-2 last:border-b-0">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 dark:text-white truncate">{{ $article->title }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Kategori:
                                    {{ $article->category->name }}</p>
                            </div>
                            <span
                                class="mt-2 sm:mt-0 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 text-sm px-2 py-1 rounded-full flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ number_format($article->views) }} views</span>
                            </span>
                        </li>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400">Tidak ada artikel terpopuler.</p>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
