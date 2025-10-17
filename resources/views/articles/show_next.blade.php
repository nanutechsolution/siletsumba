@foreach ($content as $paragraph)
<p>{!! $paragraph !!}</p>
@endforeach

@if ($nextOffset < count(explode('</p>', $article->full_content)))
    <div class="my-6 text-center">
        <a href="{{ route('articles.next_part', $article->slug) }}?offset={{ $nextOffset }}" class="inline-block bg-silet-red text-white px-4 py-2 rounded hover:bg-red-700 transition">
            Baca Selanjutnya →
        </a>
    </div>
    @endif
