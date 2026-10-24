@foreach ($content as $paragraph)
    @if (preg_match('/<p[\s>]/', $paragraph)){!! $paragraph !!}</p>@else{!! $paragraph !!}@endif
@endforeach

@if ($nextOffset < count(explode('</p>', $article->full_content)))
<div class="not-prose my-6 text-center">
    <a href="{{ route('articles.next_part', $article->slug) }}?offset={{ $nextOffset }}"
        class="inline-flex h-11 items-center rounded-full bg-silet-red px-6 text-sm font-semibold text-white hover:bg-red-700">
        Baca selanjutnya
    </a>
</div>
@endif
