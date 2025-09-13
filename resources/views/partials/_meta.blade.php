@php
    // Meta defaults
    $metaTitle = $article->title . ' - Silet Sumba';
    $metaDescription = $article->excerpt ?? Str::limit(strip_tags($article->content), 160);
    $metaImage = $article->images->first()->path ?? Storage::url($settings['site_logo_url']->value);
    $metaUrl = url()->current();
    $publishedTime = $article->created_at ? $article->created_at->toIso8601String() : now()->toIso8601String();
    $modifiedTime = $article->updated_at ? $article->updated_at->toIso8601String() : $publishedTime;
@endphp

<!-- Primary Meta Tags -->
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<link rel="canonical" href="{{ $metaUrl }}" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:url" content="{{ $metaUrl }}">
<meta property="og:site_name" content="Silet Sumba">
<meta property="article:published_time" content="{{ $publishedTime }}">
<meta property="article:modified_time" content="{{ $modifiedTime }}">
<meta property="article:author" content="{{ $article->user->name ?? 'Redaksi' }}">
@foreach ($article->tags as $tag)
    <meta property="article:tag" content="{{ $tag->name }}">
@endforeach

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">
<meta name="twitter:site" content="@siletsumba">
<meta name="twitter:creator" content="@siletsumba">
@php
    $articleJson = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current(),
        ],
        'headline' => $article->title,
        'image' => [$article->images->first()?->path ?? Storage::url($settings['site_logo_url']->value)],
        'datePublished' => $article->created_at?->toIso8601String() ?? now()->toIso8601String(),
        'dateModified' =>
            $article->updated_at?->toIso8601String() ??
            ($article->created_at?->toIso8601String() ?? now()->toIso8601String()),
        'author' => [
            '@type' => 'Person',
            'name' => $article->user->name ?? 'Redaksi',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Silet Sumba',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => Storage::url($settings['site_logo_url']->value),
            ],
        ],
        'description' => $article->excerpt ?? Str::limit(strip_tags($article->content), 160),
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($articleJson, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
