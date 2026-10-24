<div class="space-y-10 lg:sticky lg:top-20">
    <section aria-label="Terpopuler">
        <div class="border-t-2 border-silet-red pt-3">
            <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Terpopuler</h2>
        </div>
        <ol class="divide-y divide-stone-200 dark:divide-stone-800">
            @foreach ($popular as $index => $pop)
            <li>
                <a href="{{ route('articles.show', $pop->slug) }}" class="flex gap-4 py-3.5">
                    <span class="w-7 flex-shrink-0 font-serif text-2xl font-bold leading-none text-sumba-gold">{{ $index + 1 }}</span>
                    <span class="line-clamp-3 font-serif text-base font-semibold leading-snug">{{ strip_tags($pop->title) }}</span>
                </a>
            </li>
            @endforeach
        </ol>
    </section>

    <section aria-label="Terbaru" class="hidden lg:block">
        <div class="border-t-2 border-stone-900 pt-3 dark:border-stone-100">
            <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Terbaru</h2>
        </div>
        <div class="divide-y divide-stone-200 dark:divide-stone-800">
            @foreach ($latest as $news)
            <a href="{{ route('articles.show', $news->slug) }}" class="block py-3.5 font-serif text-base font-semibold leading-snug hover:text-silet-red">
                {{ strip_tags($news->title) }}
            </a>
            @endforeach
        </div>
    </section>
</div>
