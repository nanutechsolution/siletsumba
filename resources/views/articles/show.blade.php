@extends('welcome')

@section('content')
    <div class="container mx-auto px-4 py-6">
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
                    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200 dark:border-gray-700">
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

                        <div class="flex items-center space-x-4 text-gray-600 dark:text-gray-400 text-sm">
                            <div class="flex items-center space-x-1"><i class="fas fa-eye"></i>
                                <span>{{ number_format($article->views) }}</span>
                            </div>
                            <div class="flex items-center space-x-1"><i class="far fa-thumbs-up"></i>
                                <span>{{ number_format($article->likes) }}</span>
                            </div>
                            <div class="flex items-center space-x-1 hover:text-blue-600 cursor-pointer"
                                onclick="document.getElementById('comments-section').scrollIntoView({ behavior: 'smooth' })">
                                <i class="far fa-comment"></i> <span>{{ $article->comments_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="w-full overflow-hidden">
                        @if ($article->hasMedia('images'))
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
                        @else
                            <img src="https://via.placeholder.com/1200x675?text=No+Image" alt="No image available"
                                class="w-full h-auto object-cover" loading="lazy">
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="px-4 py-6 space-y-6">
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

                        <!-- Share Buttons -->
                        <div class="flex items-center gap-4 mt-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Bagikan:</span>
                            @php
                                $shareButtons = [
                                    'WhatsApp' => [
                                        'url' =>
                                            'https://api.whatsapp.com/send?text=' .
                                            urlencode($metaTitle . ' ' . $shareUrl),
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
