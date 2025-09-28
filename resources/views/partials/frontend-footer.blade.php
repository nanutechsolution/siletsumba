<footer class="bg-silet-dark text-white py-12 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            <!-- Kolom 1: Brand -->
            <div>
                <h4 class="font-bold text-xl mb-3 text-silet-red">
                    {{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                </h4>
                <p class="text-gray-300 dark:text-gray-400 mb-4 text-sm leading-relaxed">
                    {{ $settings['site_description']->value ?? 'Media berita terkini dan terpercaya dari Sumba.' }}
                </p>
                <div class="flex space-x-3">
                    @foreach (['facebook' => 'M18 2h-3a6 6 0 0 0-6 6v3H6v4h3v8h4v-8h3l1-4h-4V8a1 1 0 0 1 1-1h3V2z',
                    'twitter' => 'M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 22.4.36a9.05 9.05 0 0 1-2.88 1.1 4.52 4.52 0 0 0-7.72 4.12A12.85 12.85 0 0 1 1.64 2.16a4.52 4.52 0 0 0 1.4 6.05A4.41 4.41 0 0 1 .96 7.7v.05a4.52 4.52 0 0 0 3.63 4.42 4.52 4.52 0 0 1-2.04.08 4.52 4.52 0 0 0 4.22 3.13A9.07 9.07 0 0 1 0 19.54 12.81 12.81 0 0 0 6.92 21c8.32 0 12.87-6.9 12.87-12.87 0-.2 0-.42-.01-.63A9.2 9.2 0 0 0 24 4.56a9.3 9.3 0 0 1-2.54.7z',
                    'instagram' => 'M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm0 2h10c1.66 0 3 1.34 3 3v10c0 1.66-1.34 3-3 3H7c-1.66 0-3-1.34-3-3V7c0-1.66 1.34-3 3-3zm8 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'] as $platform => $svgPath)
                    @php
                    $urlKey = "social_{$platform}_url";
                    $label = ucfirst($platform);
                    @endphp
                    @if (!empty($settings[$urlKey]->value))
                    <a href="{{ $settings[$urlKey]->value }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition" aria-label="Ikuti kami di {{ $label }}">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="{{ $svgPath }}"></path>
                        </svg>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Kolom 2: Kategori Utama -->
            <div>
                <h4 class="font-bold text-lg mb-4">{{ __('KATEGORI UTAMA') }}</h4>
                <ul class="space-y-2">
                    @foreach ($footerCategories as $category)
                    <li>
                        <a href="{{ route('articles.category', $category->slug) }}" class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition text-sm dark:hover:text-silet-red">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Kolom 3: Informasi -->
            <div>
                <h4 class="font-bold text-lg mb-4">{{ __('TENTANG KAMI') }}</h4>
                <ul class="space-y-2 text-sm">
                    @foreach ($footerPages as $page)
                    <li>
                        <a href="{{ route('page.show', $page->slug) }}" class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition dark:hover:text-silet-red">
                            {{ $page->title }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 dark:border-gray-600 mt-8 pt-6 text-center">
            <p class="text-gray-400 text-xs">
                © {{ date('Y') }} {{ $settings['site_name']->value ?? 'SILET SUMBA' }}. Hak cipta dilindungi
                undang-undang.
            </p>
        </div>
    </div>
</footer>
