@extends('welcome')

@section('content')
<div class="mx-auto py-2">
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
                        <img src="{{ $article->user->getFirstMediaUrl('profile_photos', 'small') }}" alt="{{ $article->user->name }}" class="w-8 h-8 rounded-full object-cover" loading="lazy">
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
                <h1 class="p-4 space-y-6 text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white leading-snug">
                    {!! $article->title !!}
                </h1>
                <div class="relative w-full h-[400px] md:h-[500px] lg:h-[600px] rounded-lg overflow-hidden">
                    @if ($article->hasMedia('images'))
                    @php $media = $article->getFirstMedia('images'); @endphp
                    <img src="{{ $media->getUrl('responsive') }}" srcset="{{ $media->getSrcset('responsive') }}" sizes="100vw" alt="{{ $article->title ?? 'Hero Image' }}" loading="lazy" class="w-full h-full object-cover object-center" />
                    @endif
                </div>


                <!-- Interaction Bar -->
                <div class="bg-white dark:bg-gray-800 flex items-center justify-between px-4 py-2 shadow-sm rounded-lg mt-4">
                    <!-- Left: Views, Likes, Comments -->
                    <div class="flex items-center space-x-6 text-gray-600 dark:text-gray-400 text-sm">
                        <!-- Views -->
                        @auth
                        <div class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <span>{{ number_format($article->views) }}</span>
                        </div>
                        @endauth
                        <!-- Likes -->
                        <div class="flex items-center space-x-1">
                            @guest
                            <button onclick="document.getElementById('login-modal').classList.remove('hidden')" class="flex items-center space-x-1 hover:text-blue-500 transition p-1 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                </svg>

                                <span>{{ number_format($article->likes) }}</span>
                            </button>
                            @endguest
                            @auth
                            <form action="{{ route('articles.like', $article->slug) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center space-x-1 hover:text-blue-500 transition p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                    </svg>

                                    <span>{{ number_format($article->likes) }}</span>
                                </button>
                            </form>
                            @endauth
                        </div>

                        <!-- Comments -->
                        <div class="flex items-center space-x-1 cursor-pointer hover:text-blue-500 transition" onclick="document.getElementById('comments-section').scrollIntoView({ behavior: 'smooth' })">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            <span>{{ $article->comments_count ?? 0 }}</span>
                        </div>
                    </div>
                    <div x-data="{ open: false, copied: false }" class="relative">
                        <!-- Tombol Share -->
                        <button @click="open = true" class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-green-600 transition p-2 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                            </svg>
                            <span>Bagikan</span>
                        </button>

                        <!-- Modal Share -->
                        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div @click.outside="open = false" x-transition.scale class="bg-white dark:bg-gray-800 rounded-xl p-5 w-80 sm:w-96 shadow-xl transform transition-all">

                                <!-- Header Modal -->
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Bagikan Artikel</h2>
                                    <button @click="open = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Copy Link -->
                                <div class="flex mb-3 relative group">
                                    <input type="text" readonly value="{{ url()->current() }}" class="flex-1 p-2 border border-gray-300 rounded-l-lg text-sm dark:bg-gray-700 dark:text-gray-100">
                                    <button @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2000)" class="bg-green-600 text-white px-4 rounded-r-lg hover:bg-green-500 transition transform hover:scale-110">
                                        <span x-show="!copied">Copy</span>
                                        <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    <!-- Tooltip -->
                                    <div class="absolute top-0 -mt-6 left-1/2 -translate-x-1/2 bg-gray-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                        Klik untuk menyalin
                                    </div>
                                </div>

                                <!-- Toast -->
                                <div x-show="copied" x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-4 opacity-0" class="fixed bottom-5 left-1/2 -translate-x-1/2 bg-green-600 text-white px-4 py-2 rounded shadow-md">
                                    Link berhasil disalin!
                                </div>

                                <!-- Share Buttons -->
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="flex items-center justify-center space-x-2 p-2 bg-green-50 hover:bg-green-100 rounded-lg text-green-600 font-medium transition transform hover:scale-110 hover:shadow-lg">
                                        <i class="fab fa-whatsapp fa-lg"></i>
                                        <span>WhatsApp</span>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="flex items-center justify-center space-x-2 p-2 bg-blue-50 hover:bg-blue-100 rounded-lg text-blue-600 font-medium transition transform hover:scale-110 hover:shadow-lg">
                                        <i class="fab fa-facebook fa-lg"></i>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="flex items-center justify-center space-x-2 p-2 bg-blue-50 hover:bg-blue-100 rounded-lg text-blue-400 font-medium transition transform hover:scale-110 hover:shadow-lg">
                                        <i class="fab fa-x fa-lg"></i>
                                        <span>Twitter</span>
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="flex items-center justify-center space-x-2 p-2 bg-blue-50 hover:bg-blue-100 rounded-lg text-blue-500 font-medium transition transform hover:scale-110 hover:shadow-lg">
                                        <i class="fab fa-telegram fa-lg"></i>
                                        <span>Telegram</span>
                                    </a>
                                </div>

                                <!-- Close Button -->
                                <button @click="open = false" class="mt-5 w-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="login-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-80 text-center space-y-4">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Silakan login</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Anda harus login untuk menyukai artikel
                            ini.
                        </p>
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Login</a>
                        <button onclick="document.getElementById('login-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 text-sm">Tutup</button>
                    </div>
                </div>
                <!-- Content -->
                <div class="px-4  space-y-6">


                    <div class="prose dark:prose-invert max-w-none">
                        {!! $article->full_content !!}
                    </div>
                    <!-- Tags -->
                    <section aria-label="tags">
                        @if ($article->tags->count())
                        <div class="flex flex-wrap gap-2 py-4">
                            @foreach ($article->tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-silet-red hover:text-white">
                                #{{ $tag->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </section>

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
