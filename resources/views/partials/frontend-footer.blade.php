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
                    @foreach (['facebook' => 'fab fa-facebook', 'twitter' => 'fab fa-twitter', 'instagram' => 'fab fa-instagram', 'youtube' => 'fab fa-youtube'] as $platform => $icon)
                        @php
                            $urlKey = "social_{$platform}_url";
                            $label = ucfirst($platform);
                        @endphp
                        @if (!empty($settings[$urlKey]->value))
                            <a href="{{ $settings[$urlKey]->value }}" target="_blank" rel="noopener noreferrer"
                                class="text-gray-400 hover:text-white transition"
                                aria-label="Ikuti kami di {{ $label }}">
                                <i class="{{ $icon }} text-lg"></i>
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
                            <a href="{{ route('articles.category', $category->slug) }}"
                                class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition text-sm dark:hover:text-silet-red">
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
                            <a href="{{ route('page.show', $page->slug) }}"
                                class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition dark:hover:text-silet-red">
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
