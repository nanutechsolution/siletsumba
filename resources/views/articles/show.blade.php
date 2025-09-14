@extends('welcome')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-tribun-gray dark:bg-gray-800 py-2">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ url('/') }}" class="hover:text-tribun-red">Home</a>
                <span class="mx-1">></span>
                @if ($article->category?->parent)
                    <a href="{{ route('home', $article->category->parent->slug) }}" class="hover:text-tribun-red">
                        {{ $article->category->parent->name }}
                    </a>
                    <span class="mx-1">></span>
                @endif

                <a href="{{ route('home', $article->category->slug) }}" class="hover:text-tribun-red">
                    {{ $article->category->name }}
                </a>
                <span class="mx-1">></span>

                <span class="text-tribun-red">
                    {{ Str::limit(strip_tags($article->title, 30)) }}
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Article Content (3/4) -->
        <div class="lg:col-span-3">
            @php
                // Variabel untuk share
                $metaTitle = $article->title . ' - Silet Sumba';
                $metaDescription = $article->excerpt ?? Str::limit(strip_tags($article->content), 160);
                $metaImage = $article->images->first()?->path ?? Storage::url($settings['site_logo_url']->value);
                $shareUrl = url()->current();
            @endphp
            <article
                class="bg-white dark:bg-gray-950 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-800 transition">
                <!-- Category -->
                <div class="px-8 pt-8">
                    <span
                        class="inline-block text-white text-xs md:text-sm font-semibold px-4 py-1.5 rounded-full shadow-sm uppercase tracking-wide"
                        style="background-color: {{ $article->category->color }}">
                        {{ $article->category->name }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="px-8 pt-4 text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight">
                    {!! $article->title !!}
                </h1>

                <!-- Meta Info -->
                <div class="px-8 mt-5 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-gray-500 dark:text-gray-400">
                    <!-- Author -->
                    <div class="flex items-center gap-3">
                        @if (!empty($article->user?->profile_photo_path))
                            <img src="{{ Storage::url($article->user->profile_photo_path) }}"
                                alt="{{ $article->user->name }}"
                                class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700 shadow-sm">
                        @else
                            <i class="fas fa-user-circle text-3xl"></i>
                        @endif
                        <span class="font-medium">{{ $article->user->name ?? 'Redaksi' }}</span>
                    </div>

                    <!-- Date -->
                    <div class="flex items-center gap-2">
                        <i class="far fa-clock"></i>
                        <span>{{ $article->created_at->format('d F Y - H:i') }} WITA</span>
                    </div>

                    <!-- Views -->
                    <div class="flex items-center gap-2">
                        <i class="fas fa-eye"></i>
                        <span>{{ number_format($article->views) }} kali dibaca</span>
                    </div>

                    <!-- Likes -->
                    <div class="flex items-center gap-2">
                        <i class="far fa-thumbs-up"></i>
                        <span>{{ number_format($article->likes) }} suka</span>
                    </div>

                    <!-- Komentar -->
                    <div class="flex items-center gap-2">
                        <i class="far fa-comment"></i>
                        <span>{{ $article->comments_count ?? 0 }} komentar</span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="mt-8 relative">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}"
                        class="w-full h-[460px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></div>
                </div>

                <!-- Content -->
                <div class="article-content prose prose-lg dark:prose-invert px-8 mt-10 max-w-none leading-relaxed">
                    {!! $article->full_content !!}
                </div>

                <!-- Tags -->
                @if ($article->tags->count())
                    <div class="px-8 mt-12 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-3">Topik Terkait:</h4>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($article->tags as $tag)
                                <a href="{{ route('tags.show', $tag->slug) }}"
                                    class="px-4 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-xs md:text-sm font-medium hover:bg-tribun-red hover:text-white transition">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share -->
                <div class="px-8 mt-12 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Bagikan artikel ini:</span>
                        <div class="flex gap-5 text-xl">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($metaTitle . ' ' . $shareUrl) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="text-green-500 hover:text-green-700 transition"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="text-blue-600 hover:text-blue-800 transition"><i class="fab fa-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($metaTitle) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="text-sky-500 hover:text-sky-700 transition"><i class="fab fa-twitter"></i></a>
                            <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($metaTitle) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="text-gray-800 dark:text-gray-300 hover:text-black transition"><i
                                    class="fab fa-telegram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="px-8 mt-12 border-t border-gray-200 dark:border-gray-700 pt-8 pb-10">
                    <div class="flex items-center gap-5">
                        @if (!empty($article->user?->profile_photo_path))
                            <img src="{{ Storage::url($article->user->profile_photo_path) }}"
                                alt="{{ $article->user->name }}"
                                class="w-16 h-16 rounded-full object-cover shadow-lg ring-2 ring-gray-200 dark:ring-gray-700">
                        @else
                            <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                        @endif

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $article->user->name ?? 'Redaksi' }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                @if (!empty($article->user?->bio))
                                    {{ $article->user->bio }}
                                @else
                                    <span class="font-medium">Silet Sumba</span> — Portal Berita Lokal Terpercaya
                                @endif
                            </p>

                            <!-- Socials -->
                            <div class="flex gap-4 mt-2 text-lg">
                                <a href="https://www.facebook.com/bung.kobus.2025"
                                    class="text-blue-600 hover:text-blue-800 transition"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="text-sky-500 hover:text-sky-700 transition"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="#" class="text-pink-500 hover:text-pink-700 transition"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            {{-- 
            <!-- Article Header -->
            <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <span class=" text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block"
                    style="background-color: {{ $article->category->color }}">
                    {{ $article->category->name }}
                </span>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">
                    {!! $article->title !!}
                </h1>

                <div class="flex flex-wrap items-center text-sm text-gray-600 dark:text-gray-400 mb-6">
                    <!-- Author -->
                    <div class="flex items-center mr-6 mb-2">
                        @if (!empty($article->user?->profile_photo_path))
                            <img src="{{ Storage::url($article->user->profile_photo_path) }}"
                                alt="{{ $article->user->name }}" class="w-12 h-12 rounded-full mr-2 object-cover">
                        @else
                            <i class="fas fa-user-circle mr-2"></i>
                        @endif
                        {{ $article->user->name ?? 'Redaksi' }}
                    </div>

                    <!-- Tanggal -->
                    <div class="flex items-center mr-6 mb-2">
                        <i class="far fa-clock mr-2"></i>
                        <span>{{ $article->created_at->format('d F Y - H:i') }} WITA</span>
                    </div>

                    <!-- Views -->
                    <div class="flex items-center mr-6 mb-2">
                        <i class="fas fa-eye mr-2"></i>
                        <span>{{ number_format($article->views) }} Views</span>
                    </div>
                    <div class="flex items-center mr-6 mb-2  space-x-4">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">{{ number_format($article->likes) }}</span> Suka
                        </p>

                        @guest
                            <button type="button" class="text-gray-400 cursor-not-allowed">
                                <i class="far fa-thumbs-up mr-2"></i>
                            </button>
                            <p class="text-sm text-gray-500">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a> untuk
                                menyukai
                                artikel ini.
                            </p>
                        @endguest

                        @auth
                            <form action="{{ route('articles.like', $article->slug) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="far fa-thumbs-up mr-2"></i>
                                </button>
                            </form>
                        @endauth
                    </div>
                    <!-- Komentar -->
                    <div class="flex items-center mb-2">
                        <i class="far fa-comment mr-2"></i>
                        <span>{{ $article->comments_count ?? 0 }} Komentar</span>
                    </div>
                </div>


                <!-- Featured Image -->
                <div class="mb-6">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-96 object-cover">
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-2">
                        {!! $article->title !!}
                    </p>
                </div>
                <!-- Article Content -->
                <div class="article-content prose dark:prose-invert max-w-none">
                    {!! $article->full_content !!}
                </div>

                <!-- Article Tags -->
                @if ($article->tags->count())
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tags:</span>
                            @foreach ($article->tags as $tag)
                                <a href="{{ route('tags.show', $tag->slug) }}"
                                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-tribun-red hover:text-white">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif


                <!-- Social Share -->
                <div class="mt-6 flex items-center gap-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Bagikan:</span>

                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($metaTitle . ' ' . $shareUrl) }}"
                        target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-800">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank"
                        rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>

                    <!-- Twitter (X) -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($metaTitle) }}"
                        target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-600">
                        <i class="fab fa-x text-xl"></i>
                    </a>

                    <!-- Telegram -->
                    <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($metaTitle) }}"
                        target="_blank" rel="noopener noreferrer" class="text-gray-800 hover:text-black">
                        <i class="fab fa-telegram text-xl"></i>
                    </a>
                </div>
                <!-- Author Box -->
                <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <!-- Foto Penulis -->
                        @if (!empty($article->user?->profile_photo_path))
                            <img src="{{ Storage::url($article->user->profile_photo_path) }}"
                                alt="{{ $article->user->name }}" class="w-12 h-12 rounded-full object-cover shadow-md">
                        @else
                            <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                        @endif

                        <!-- Info Penulis -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $article->user->name ?? 'Redaksi' }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                @if (!empty($article->user?->bio))
                                    {{ $article->user->bio }}
                                @else
                                    <span class="font-medium">Silet Sumba</span>.
                                @endif
                            </p>

                            <!-- Sosmed -->
                            <div class="flex gap-3 mt-2">
                                <a href="https://www.facebook.com/bung.kobus.2025"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="fab fa-facebook text-sm"></i>
                                </a>
                                <a href="#" class="text-blue-400 hover:text-blue-600">
                                    <i class="fab fa-twitter text-sm"></i>
                                </a>
                                <a href="#" class="text-pink-500 hover:text-pink-700">
                                    <i class="fab fa-instagram text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </article> --}}

            <!-- Related News -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">BERITA TERKAIT</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($related as $rel)
                        <a href="{{ route('articles.show', $rel->slug) }}" class="flex items-start space-x-4 group">
                            <img src="{{ $rel->image_url ?? 'https://via.placeholder.com/100x80' }}"
                                alt="{{ $rel->title }}" class="w-20 h-16 object-cover rounded">
                            <div>
                                <h3
                                    class="font-semibold text-gray-800 dark:text-white group-hover:text-tribun-red cursor-pointer">
                                    {{ $rel->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $rel->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada berita terkait.</p>
                    @endforelse
                </div>


            </div>


            <!-- Comments Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                    KOMENTAR ({{ $article->comments()->where('status', 'approved')->count() }})
                </h2>

                <!-- Comment Form -->
                <div class="mb-8">
                    <!-- Comment Form -->
                    <form action="{{ route('comments.store', $article->slug) }}" method="POST">
                        @csrf
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <div class="mb-4">
                            <label for="name"
                                class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama</label>
                            <input type="text" name="name" id="name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email"
                                class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email</label>
                            <input type="email" name="email" id="email"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="body" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Isi
                                Komentar</label>
                            <textarea name="body" id="body" rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required></textarea>
                            @error('body')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="bg-tribun-red text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Kirim
                            </button>
                        </div>
                    </form>

                </div>

                <!-- Comments List -->
                <div class="space-y-6 mt-8">
                    @forelse ($article->comments->where('status', 'approved') as $comment)
                        <div class="flex space-x-4">
                            <img src="https://via.placeholder.com/50" alt="User" class="w-12 h-12 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-gray-800 dark:text-white">{{ $comment->name }}</h4>
                                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Belum ada komentar.</p>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- Sidebar (1/4) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Popular News -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">BERITA POPULER</h2>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($popular as $index => $pop)
                        <a href="{{ route('articles.show', $pop->slug) }}"
                            class="flex items-start space-x-3 py-3 hover:text-tribun-red transition">
                            <span
                                class="bg-tribun-red text-white w-6 h-6 rounded-full flex items-center 
                                 justify-center text-xs font-bold mt-1">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-sm font-medium text-gray-800 dark:text-white truncate w-48">
                                {{ $pop->title }}
                            </p>

                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Advertisement -->
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">ADVERTISEMENT</p>
                <div class="bg-white dark:bg-gray-600 p-4 rounded">
                    <img src="https://via.placeholder.com/300x250" alt="Iklan" class="mx-auto rounded">
                    <p class="text-xs mt-2 text-gray-600 dark:text-gray-300">Sponsored Content</p>
                </div>
            </div>

            <!-- Latest News -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">TERBARU</h2>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($latest as $news)
                        <a href="{{ route('articles.show', $news->slug) }}"
                            class="block py-2 text-sm font-medium text-gray-800 dark:text-white 
                          hover:text-tribun-red truncate">
                            {{ $news->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
