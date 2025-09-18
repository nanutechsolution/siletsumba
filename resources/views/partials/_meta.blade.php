    @php
        $metaTitle = isset($article) ? $article->title . ' - Silet Sumba' : 'Silet Sumba';
        $metaDescription = isset($article)
            ? $article->excerpt ?? Str::limit(strip_tags($article->content), 160)
            : 'Berita terbaru Silet Sumba';
        $metaImage =
            isset($article) && $article->image_url
                ? url($article->image_url)
                : Storage::url($settings['site_logo_url']->value);
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
    <meta property="fb:app_id" content="848147202689080">


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
                    isset($article) && $article->images->first()
                        ? url(Storage::url($article->images->first()->path))
                        : url(Storage::url($settings['site_logo_url']->value)),
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
                    'image' =>
                        $article->user?->profile_photo_path ?? url(Storage::url($settings['site_logo_url']->value)),
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
