@extends('welcome')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 dark:text-gray-400 mb-4" aria-label="Breadcrumb">
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
            <span> &gt; </span>
            <span class="text-silet-red truncate inline-block max-w-[150px] align-bottom">
                {{ Str::limit(strip_tags($article->title), 30) }}
            </span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Article -->
            <div class="lg:col-span-3 space-y-6">
                @php
                    $metaTitle = $article->title . ' - Silet Sumba';
                    $metaDescription = $article->excerpt ?? Str::limit(strip_tags($article->content), 160);
                    $metaImage = $article->images->first()?->path ?? Storage::url($settings['site_logo_url']->value);
                    $shareUrl = url()->current();
                @endphp

                <!-- Article Header -->
                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <span class="text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block"
                        style="background-color: {{ $article->category->color }}">
                        {{ $article->category->name }}
                    </span>

                    <h1 class="font-bold text-gray-800 dark:text-white mb-4 leading-snug text-2xl sm:text-3xl lg:text-4xl">
                        {!! $article->title !!}
                    </h1>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center text-sm text-gray-600 dark:text-gray-400 mb-6 space-x-4">
                        <!-- Author -->
                        <div class="flex items-center space-x-2">
                            @if ($article->user?->hasMedia('profile_photos'))
                                <img src="{{ $article->user->getFirstMediaUrl('profile_photos', 'small') }}"
                                    alt="{{ $article->user->name }}" class="w-10 h-10 rounded-full object-cover"
                                    loading="lazy">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                            @endif
                            <span>{{ $article->user->name ?? 'Redaksi' }}</span>
                        </div>

                        <!-- Date -->
                        <div class="flex items-center space-x-1">
                            <i class="far fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($article->scheduled_at ?? $article->created_at)->format('d F Y - H:i') }}
                                WITA</span>
                        </div>

                        <!-- Views -->
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($article->views) }} Dibaca</span>
                        </div>

                        <!-- Likes -->
                        <div class="flex items-center space-x-2">
                            <span class="font-medium">{{ number_format($article->likes) }}</span>
                            @guest
                                <span class="text-gray-500 text-sm">Suka (Login untuk like)</span>
                            @endguest
                            @auth
                                <form action="{{ route('articles.like', $article->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="far fa-thumbs-up"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <!-- Comments Count -->
                        <div class="flex items-center space-x-1">
                            <i class="far fa-comment"></i>
                            <span>{{ $article->comments_count ?? 0 }} Komentar</span>
                        </div>
                    </div>

                    <!-- Featured Image -->

                    <div class="w-full aspect-[16/9] overflow-hidden rounded-lg mb-4">
                        @if ($article->hasMedia('images'))
                            <picture>
                                <source
                                    srcset="
                                {{ $article->getFirstMediaUrl('images', '400') }} 400w,
                                {{ $article->getFirstMediaUrl('images', '800') }} 800w,
                                {{ $article->getFirstMediaUrl('images', '1200') }} 1200w
                            "
                                    type="image/webp">
                                <img srcset="
                                {{ $article->getFirstMediaUrl('images', '400') }} 400w,
                                {{ $article->getFirstMediaUrl('images', '800') }} 800w,
                                {{ $article->getFirstMediaUrl('images', '1200') }} 1200w
                            "
                                    src="{{ $article->getFirstMediaUrl('images', '800') }}" alt="{{ $article->title }}"
                                    sizes="(max-width: 640px) 100vw, (max-width: 1024px) 80vw, 1200px"
                                    class="w-full h-full object-cover object-center rounded-lg" loading="lazy">
                            </picture>
                        @else
                            <img src="https://via.placeholder.com/1200x675?text=No+Image" alt="No image available"
                                class="w-full h-full object-cover rounded-lg" loading="lazy">
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $article->full_content !!}
                    </div>

                    <!-- Tags -->
                    @if ($article->tags->count())
                        <div class="mt-6 flex flex-wrap gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tags:</span>
                            @foreach ($article->tags as $tag)
                                <a href="{{ route('tags.show', $tag->slug) }}"
                                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-silet-red hover:text-white">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-6 flex items-center gap-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Bagikan:</span>
                        @php
                            $shareButtons = [
                                'WhatsApp' => [
                                    'url' =>
                                        'https://api.whatsapp.com/send?text=' . urlencode($metaTitle . ' ' . $shareUrl),
                                    'color' => 'text-green-600 hover:text-green-800',
                                    'icon' => 'fab fa-whatsapp',
                                ],
                                'Facebook' => [
                                    'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($shareUrl),
                                    'color' => 'text-blue-600 hover:text-blue-800',
                                    'icon' => 'fab fa-facebook',
                                ],
                                'Twitter' => [
                                    'url' =>
                                        'https://twitter.com/intent/tweet?url=' .
                                        urlencode($shareUrl) .
                                        '&text=' .
                                        urlencode($metaTitle),
                                    'color' => 'text-blue-600 hover:text-blue-800',
                                    'icon' => 'fab fa-x',
                                ],
                                'Telegram' => [
                                    'url' =>
                                        'https://t.me/share/url?url=' .
                                        urlencode($shareUrl) .
                                        '&text=' .
                                        urlencode($metaTitle),
                                    'color' =>
                                        'text-gray-800 dark:text-gray-200 hover:text-black dark:hover:text-white',
                                    'icon' => 'fab fa-telegram',
                                ],
                            ];
                        @endphp
                        @foreach ($shareButtons as $label => $btn)
                            <a href="{{ $btn['url'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Bagikan ke {{ $label }}"
                                class="{{ $btn['color'] }} focus:outline-none focus:ring-2 focus:ring-gray-500 rounded text-xl">
                                <i class="{{ $btn['icon'] }}"></i>
                                <span class="sr-only">{{ $label }}</span>
                            </a>
                        @endforeach
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
