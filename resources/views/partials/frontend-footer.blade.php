<footer class="mt-8 bg-stone-900 text-stone-300">
    <div class="tenun-strip" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-4 py-12">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-3">
            <div>
                <p class="font-serif text-2xl font-bold text-white">
                    {{ $settings['site_name']->value ?? 'Silet Sumba' }}
                </p>
                <p class="mt-3 text-sm leading-relaxed text-stone-400">
                    {{ $settings['site_description']->value ?? 'Media berita terkini dan terpercaya dari Sumba.' }}
                </p>
                <div class="mt-5 flex gap-3">
                    @foreach (['facebook' => 'M18 2h-3a6 6 0 0 0-6 6v3H6v4h3v8h4v-8h3l1-4h-4V8a1 1 0 0 1 1-1h3V2z',
                    'twitter' => 'M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 22.4.36a9.05 9.05 0 0 1-2.88 1.1 4.52 4.52 0 0 0-7.72 4.12A12.85 12.85 0 0 1 1.64 2.16a4.52 4.52 0 0 0 1.4 6.05A4.41 4.41 0 0 1 .96 7.7v.05a4.52 4.52 0 0 0 3.63 4.42 4.52 4.52 0 0 1-2.04.08 4.52 4.52 0 0 0 4.22 3.13A9.07 9.07 0 0 1 0 19.54 12.81 12.81 0 0 0 6.92 21c8.32 0 12.87-6.9 12.87-12.87 0-.2 0-.42-.01-.63A9.2 9.2 0 0 0 24 4.56a9.3 9.3 0 0 1-2.54.7z',
                    'instagram' => 'M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm0 2h10c1.66 0 3 1.34 3 3v10c0 1.66-1.34 3-3 3H7c-1.66 0-3-1.34-3-3V7c0-1.66 1.34-3 3-3zm8 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'] as $platform => $svgPath)
                    @php $urlKey = "social_{$platform}_url"; @endphp
                    @if (!empty($settings[$urlKey]->value))
                    <a href="{{ $settings[$urlKey]->value }}" target="_blank" rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-stone-700 text-stone-400 transition hover:border-white hover:text-white"
                        aria-label="Ikuti kami di {{ ucfirst($platform) }}">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="{{ $svgPath }}"></path></svg>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Kategori</p>
                <ul class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    @foreach ($footerCategories as $category)
                    <li><a href="{{ route('articles.category', $category->slug) }}" class="hover:text-white">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Tentang kami</p>
                <ul class="mt-4 space-y-2 text-sm">
                    @foreach ($footerPages as $page)
                    <li><a href="{{ route('page.show', $page->slug) }}" class="hover:text-white">{{ $page->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-stone-800 pt-6 text-center text-xs text-stone-500">
            © {{ date('Y') }} {{ $settings['site_name']->value ?? 'Silet Sumba' }}. Hak cipta dilindungi undang-undang.
        </div>
    </div>
</footer>
