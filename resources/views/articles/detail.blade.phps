@extends('welcome')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb -->
        <nav class="bg-gray-100 rounded-lg p-3 mb-6">
            <ol class="list-reset flex text-sm">
                <li><a href="{{ route('home') }}" class="text-tribun-red hover:text-red-700">Home</a></li>
                <li><span class="mx-2 text-gray-500">/</span></li>
                <li><a href="{{ route('articles.category', $article->category->slug) }}"
                        class="text-tribun-red hover:text-red-700">{{ $article->category->name }}</a></li>
                <li><span class="mx-2 text-gray-500">/</span></li>
                <li class="text-gray-600">{{ Str::limit($article->title, 50) }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content (3/4) -->
            <div class="lg:col-span-3">
                <!-- Article Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <span
                        class="inline-block bg-tribun-red text-white text-sm font-semibold px-4 py-1 rounded-full uppercase mb-4">
                        {{ $article->category->name }}
                    </span>

                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $article->title }}
                    </h1>

                    <div class="flex flex-wrap items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <img src="{{ $article->author->avatar ?? 'https://placehold.co/40x40' }}"
                                    alt="{{ $article->author->name }}" class="w-10 h-10 rounded-full mr-3 object-cover">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $article->author->name }}</p>
                                    <p class="text-sm text-gray-500">Reporter Tribun News</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-6 text-sm text-gray-500 mt-4 md:mt-0">
                            <span class="flex items-center">
                                <i class="far fa-clock mr-2"></i>
                                {{ $article->created_at->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-eye mr-2"></i>
                                {{ number_format($article->views + 1) }}x dibaca
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-comment mr-2"></i>
                                {{ number_format($article->comments_count) }} komentar
                            </span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if ($article->images->count() > 0)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $article->images->first()->path) }}"
                                alt="{{ $article->title }}" class="w-full h-96 object-cover rounded-lg">
                            <p class="text-sm text-gray-500 text-center mt-2">
                                {{ $article->images->first()->caption ?? 'Ilustrasi berita' }}
                            </p>
                        </div>
                    @endif

                    <!-- Article Content -->
                    <article class="prose prose-lg max-w-none mb-8">
                        {!! $article->content !!}
                    </article>

                    <!-- Tags -->
                    @if ($article->tags->count() > 0)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-800 mb-3">Tags:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($article->tags as $tag)
                                    <a href="{{ route('articles.tag', $tag->slug) }}"
                                        class="bg-gray-100 hover:bg-tribun-red hover:text-white text-gray-700 px-3 py-1 rounded-full text-sm transition-colors">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="border-t border-b py-6 mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Bagikan:</h3>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
                                <i class="fab fa-facebook-f mr-2"></i> Facebook
                            </a>
                            <a href="#"
                                class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded flex items-center">
                                <i class="fab fa-twitter mr-2"></i> Twitter
                            </a>
                            <a href="#"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded flex items-center">
                                <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                            </a>
                            <a href="#"
                                class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded flex items-center">
                                <i class="fas fa-link mr-2"></i> Copy Link
                            </a>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="flex items-center">
                            <img src="{{ $article->author->avatar ?? 'https://placehold.co/80x80' }}"
                                alt="{{ $article->author->name }}" class="w-16 h-16 rounded-full mr-4 object-cover">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $article->author->name }}</h3>
                                <p class="text-gray-600 mb-2">Reporter Silet Sumba</p>
                                <p class="text-sm text-gray-500">
                                    {{ $article->author->bio ?? 'Penulis profesional dengan pengalaman dalam jurnalisme berita.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-bold text-xl mb-6 text-tribun-red">
                            <i class="fas fa-comments mr-2"></i>Komentar ({{ $article->comments_count }})
                        </h3>

                        <!-- Comment Form -->
                        <form class="mb-6">
                            <div class="mb-4">
                                <textarea placeholder="Tulis komentar Anda..."
                                    class="w-full border border-gray-300 rounded-lg p-4 focus:outline-none focus:border-tribun-red" rows="4"></textarea>
                            </div>
                            <button type="submit" class="bg-tribun-red hover:bg-red-700 text-white px-6 py-2 rounded">
                                Kirim Komentar
                            </button>
                        </form>

                        <!-- Comments List -->
                        <div class="space-y-4">
                            <!-- Sample Comment -->
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/40x40" alt="User" class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-semibold">Ahmad Santoso</h4>
                                            <span class="text-sm text-gray-500">2 jam lalu</span>
                                        </div>
                                        <p class="text-gray-700">
                                            Artikel yang sangat informatif! Terima kasih atas pembahasannya yang lengkap.
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <button class="text-sm text-gray-500 hover:text-tribun-red">
                                                <i class="fas fa-thumbs-up mr-1"></i> 12
                                            </button>
                                            <button class="text-sm text-gray-500 hover:text-tribun-red">
                                                <i class="fas fa-reply mr-1"></i> Balas
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Another Comment -->
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/40x40" alt="User" class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-semibold">Siti Rahayu</h4>
                                            <span class="text-sm text-gray-500">3 jam lalu</span>
                                        </div>
                                        <p class="text-gray-700">
                                            Sangat setuju dengan poin-poin yang disampaikan. Semoga pemerintah bisa
                                            menindaklanjuti.
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <button class="text-sm text-gray-500 hover:text-tribun-red">
                                                <i class="fas fa-thumbs-up mr-1"></i> 8
                                            </button>
                                            <button class="text-sm text-gray-500 hover:text-tribun-red">
                                                <i class="fas fa-reply mr-1"></i> Balas
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Articles -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-xl mb-6 text-tribun-red">
                        <i class="fas fa-newspaper mr-2"></i>BERITA TERKAIT
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($relatedArticles as $related)
                            <div class="flex space-x-4">
                                @if ($related->images->count() > 0)
                                    <img src="{{ asset('storage/' . $related->images->first()->path) }}"
                                        alt="{{ $related->title }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <img src="https://placehold.co/80x80" alt="{{ $related->title }}"
                                        class="w-20 h-20 object-cover rounded">
                                @endif
                                <div class="flex-1">
                                    <span
                                        class="text-xs text-tribun-red font-semibold">{{ $related->category->name }}</span>
                                    <a href="{{ route('articles.show', $related->slug) }}">
                                        <h4
                                            class="font-semibold text-gray-800 hover:text-tribun-red text-sm leading-tight">
                                            {{ Str::limit($related->title, 60) }}
                                        </h4>
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">{{ $related->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/4) -->
            <div class="space-y-6">
                <!-- Trending News -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="font-bold text-lg mb-4 text-tribun-red border-b pb-2">
                        <i class="fas fa-fire mr-2"></i>TRENDING NOW
                    </h3>
                    <div class="space-y-3">
                        @foreach ($trendingArticles as $index => $trending)
                            <div class="flex items-start space-x-3">
                                <span
                                    class="bg-tribun-red text-white text-xs px-2 py-1 rounded mt-1">{{ $index + 1 }}</span>
                                <div>
                                    <a href="{{ route('articles.show', $trending->slug) }}">
                                        <h4 class="font-medium hover:text-tribun-red cursor-pointer text-sm">
                                            {{ Str::limit($trending->title, 60) }}
                                        </h4>
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $trending->views }}x dibaca</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Latest News -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="font-bold text-lg mb-4 text-tribun-red border-b pb-2">
                        <i class="fas fa-clock mr-2"></i>TERBARU
                    </h3>
                    <div class="space-y-4">
                        @foreach ($latestArticles as $latest)
                            <div class="flex space-x-3">
                                <img src="{{ $latest->images->count() > 0 ? asset('storage/' . $latest->images->first()->path) : 'https://placehold.co/80x60' }}"
                                    alt="{{ $latest->title }}" class="w-20 h-15 object-cover rounded">
                                <div>
                                    <a href="{{ route('articles.show', $latest->slug) }}">
                                        <h4 class="font-medium text-sm hover:text-tribun-red cursor-pointer">
                                            {{ Str::limit($latest->title, 50) }}
                                        </h4>
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $latest->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Newsletter Subscription -->
                <div class="bg-tribun-red text-white rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-3">Berlangganan Newsletter</h3>
                    <p class="text-sm mb-4">Dapatkan berita terbaru langsung ke email Anda</p>
                    <form>
                        <input type="email" placeholder="Email Anda"
                            class="w-full px-4 py-2 rounded mb-3 text-gray-800 focus:outline-none">
                        <button type="submit" class="w-full bg-white text-tribun-red font-semibold py-2 rounded">
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Interactive Elements -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Share functionality
            document.querySelectorAll('[href="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (this.textContent.includes('Copy Link')) {
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            alert('Link berhasil disalin!');
                        });
                    }
                });
            });

            // Comment functionality
            const commentForm = document.querySelector('form');
            if (commentForm && !commentForm.action) {
                commentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Fitur komentar sedang dalam pengembangan.');
                });
            }

            // Image lazy loading
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.loading = 'lazy';
            });
        });
    </script>

    <style>
        .prose {
            color: #374151;
            line-height: 1.7;
        }

        .prose p {
            margin-bottom: 1.25em;
        }

        .prose h2 {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 2em;
            margin-bottom: 1em;
            color: #1f2937;
        }

        .prose h3 {
            font-size: 1.25em;
            font-weight: bold;
            margin-top: 1.6em;
            margin-bottom: 0.6em;
            color: #1f2937;
        }

        .prose ul,
        .prose ol {
            margin-bottom: 1.25em;
            padding-left: 1.625em;
        }

        .prose li {
            margin-bottom: 0.5em;
        }

        .prose blockquote {
            border-left: 4px solid #E41E2D;
            padding-left: 1em;
            margin: 1.5em 0;
            font-style: italic;
            color: #6b7280;
        }
    </style>
@endsection
