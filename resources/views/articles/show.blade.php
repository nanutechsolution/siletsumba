@extends('welcome')

@section('content')
    <div class=" mx-auto py-2">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-silet-red">Home</a>
            @if ($article->category?->parent)
                <span> &gt; </span>
                <a href="{{ route('home', $article->category->parent->slug) }}" class="hover:text-silet-red">
                    {{ $article->category->parent->name }}
                </a>
            @endif
            <span> &gt; </span>
            <a href="{{ route('home', $article->category->slug) }}" class="hover:text-silet-red">
                {{ $article->category->name }}
            </a>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Article -->
            <div class="lg:col-span-3 space-y-6">
                @php
                    $metaTitle = $article->title . ' - Silet Sumba';
                    $shareUrl = url()->current();
                @endphp

                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <!-- Meta Info -->
                    <div class="flex items-center justify-between px-4 py-2  border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            @if ($article->user?->hasMedia('profile_photos'))
                                <img src="{{ $article->user->getFirstMediaUrl('profile_photos', 'small') }}"
                                    alt="{{ $article->user->name }}" class="w-8 h-8 rounded-full object-cover"
                                    loading="lazy">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                            @endif
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                <div><span class="font-semibold">Penulis:</span> {{ $article->user->name ?? 'Redaksi' }}
                                </div>
                                <div>
                                    {{ \Carbon\Carbon::parse($article->scheduled_at ?? $article->created_at)->format('d F Y - H:i') }}
                                    WITA</div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="relative w-full rounded-lg overflow-hidden">
                        <picture>
                            <source
                                srcset="
            {{ $article->getFirstMediaUrl('images', '400') }} 400w,
            {{ $article->getFirstMediaUrl('images', '800') }} 800w,
            {{ $article->getFirstMediaUrl('images', '1200') }} 1200w
        "
                                type="image/webp">
                            <img src="{{ $article->getFirstMediaUrl('images', '800') }}" alt="{{ $article->title }}"
                                class="w-full h-auto object-cover object-center" loading="lazy">
                        </picture>
                    </div>
                    <!-- Interaction Bar -->
                    <div
                        class="bg-white dark:bg-gray-800 flex items-center justify-between px-4 py-2 shadow-sm rounded-lg mt-4">
                        <!-- Left: Views, Likes, Comments -->
                        <div class="flex items-center space-x-6 text-gray-600 dark:text-gray-400 text-sm">
                            <!-- Views -->
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-eye"></i>
                                <span>{{ number_format($article->views) }}</span>
                            </div>

                            <!-- Likes -->
                            <div class="flex items-center space-x-1">
                                @guest
                                    <button onclick="document.getElementById('login-modal').classList.remove('hidden')"
                                        class="flex items-center space-x-1 hover:text-blue-500 transition p-1 rounded">
                                        <i class="far fa-thumbs-up"></i>
                                        <span>{{ number_format($article->likes) }}</span>
                                    </button>
                                @endguest
                                @auth
                                    <form action="{{ route('articles.like', $article->slug) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center space-x-1 hover:text-blue-500 transition p-1 rounded">
                                            <i class="far fa-thumbs-up"></i>
                                            <span>{{ number_format($article->likes) }}</span>
                                        </button>
                                    </form>
                                @endauth
                            </div>

                            <!-- Comments -->
                            <div class="flex items-center space-x-1 cursor-pointer hover:text-blue-500 transition"
                                onclick="document.getElementById('comments-section').scrollIntoView({ behavior: 'smooth' })">
                                <i class="far fa-comment"></i>
                                <span>{{ $article->comments_count ?? 0 }}</span>
                            </div>
                        </div>
                        <!-- Right: Share Button -->
                        <div x-data="{ open: false }" class="relative flex items-center space-x-2">
                            <!-- Tombol Share -->
                            <button @click="open = !open"
                                class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-green-600 transition p-1 rounded">
                                <i class="fas fa-share"></i>
                                <span>Bagikan</span>
                            </button>

                            <!-- Dropdown Share -->
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute mt-2 right-0 bg-white dark:bg-gray-700 shadow-lg rounded-lg p-2 flex flex-col space-y-2 z-50 w-40">
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                                    target="_blank"
                                    class="hover:text-green-600 flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fab fa-whatsapp"></i> <span>WhatsApp</span>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank"
                                    class="hover:text-blue-600 flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fab fa-facebook"></i> <span>Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                                    target="_blank"
                                    class="hover:text-blue-400 flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fab fa-x"></i> <span>Twitter</span>
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                                    target="_blank"
                                    class="hover:text-blue-500 flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fab fa-telegram"></i> <span>Telegram</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Login Modal (tailwind) -->
                    <div id="login-modal"
                        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-80 text-center space-y-4">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-white">Silakan login</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Anda harus login untuk menyukai artikel ini.
                            </p>
                            <a href="{{ route('login') }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Login</a>
                            <button onclick="document.getElementById('login-modal').classList.add('hidden')"
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 text-sm">Tutup</button>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="px-4  space-y-6">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white leading-snug">
                            {!! $article->title !!}
                        </h1>

                        <div class="prose dark:prose-invert max-w-none">
                            {!! $article->full_content !!}
                        </div>

                        <!-- Tags -->
                        @if ($article->tags->count())
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach ($article->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}"
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-silet-red hover:text-white">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </article>
                <!-- Comments -->
                @include('partials.article-comments', ['article' => $article])
            </div>
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                @include('partials.sidebar', ['popular' => $popular, 'latest' => $latest])
            </div>
        </div>
    </div>
@endsection
