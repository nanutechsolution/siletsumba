    @php
        $metaTitle = isset($article)
            ? Str::limit($article->title, 60) . ' - Silet Sumba'
            : 'Silet Sumba - Berita Terbaru Sumba';
        $metaDescription = isset($article)
            ? $article->excerpt ?? Str::words(strip_tags($article->content), 25, '...')
            : 'Portal berita terbaru dan terpercaya dari Sumba. Update politik, ekonomi, budaya, dan peristiwa penting hari ini.';
        $metaImage =
            isset($article) && $article->hasMedia('images') && $article->getFirstMedia('images')
                ? $article->getFirstMediaUrl('images', 'thumb') // conversion 'thumb'
                : $settings['site_logo_url']?->getFirstMediaUrl('site_logo_url', 'thumb') ?? asset('default-logo.png');

        $metaUrl = url()->current();
        $publishedTime =
            isset($article) && $article->created_at
                ? $article->created_at->toIso8601String()
                : now()->toIso8601String();
        $modifiedTime =
            isset($article) && $article->updated_at ? $article->updated_at->toIso8601String() : $publishedTime;
    @endphp


    <!-- Primary Meta Tags -->
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $metaImage }}?v={{ now()->timestamp }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Silet Sumba">
    <meta property="article:published_time" content="{{ $publishedTime }}">
    <meta property="article:modified_time" content="{{ $modifiedTime }}">
    <meta property="article:author" content="{{ $article->user->name ?? 'Redaksi' }}">


    @isset($article)
        @foreach ($article->tags as $tag)
            <meta property="article:tag" content="{{ $tag->name }}">
        @endforeach
    @endisset

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <meta name="twitter:site" content="@siletsumba">
    <meta name="twitter:creator" content="@siletsumba">
    @php
        $articleJson = isset($article)
            ? [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => url()->current(),
                ],
                'headline' => $article->title ?? 'Silet Sumba',
                'image' => [
                    isset($article) && $article->hasMedia('images') && $article->getFirstMedia('images')
                        ? $article->getFirstMediaUrl('images', 'thumb')
                        : $settings['site_logo_url']?->getFirstMediaUrl('site_logo_url', 'thumb') ??
                            asset('default-logo.png'),
                ],
                'datePublished' =>
                    $article->scheduled_at ?? $article->created_at
                        ? ($article->scheduled_at ?? $article->created_at)->toIso8601String()
                        : now()->toIso8601String(),
                'dateModified' =>
                    $article->updated_at ?? ($article->scheduled_at ?? $article->created_at)
                        ? ($article->updated_at ?? ($article->scheduled_at ?? $article->created_at))->toIso8601String()
                        : now()->toIso8601String(),
                'author' => [
                    '@type' => 'Person',
                    'name' => $article->user?->name ?? 'Redaksi',
                    'url' => $article->user ? url('/penulis/' . $article->user->id) : url('/redaksi'),
                    'image' => $article->user?->hasMedia('profile_photos')
                        ? $article->user->getFirstMediaUrl('profile_photos', 'small')
                        : $settings['site_logo_url']?->getFirstMediaUrl('site_logo_url', 'thumb') ??
                            asset('default-logo.png'),
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'Silet Sumba',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => url(Storage::url($settings['site_logo_url']->value)),
                    ],
                ],
                'description' => $article->excerpt ?? Str::limit(strip_tags($article->content ?? ''), 160),
                'keywords' => $article->tags?->pluck('name')->implode(', ') ?? '',
            ]
            : null;
    @endphp

    @if ($articleJson)
        <script type="application/ld+json">
            {!! json_encode($articleJson, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
        </script>
    @endif
