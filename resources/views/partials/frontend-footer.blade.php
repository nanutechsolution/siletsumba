<footer class="bg-silet-dark text-white py-12 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            {{-- Kolom 1: Info Situs --}}
            <div class="text-left">
                <h4 class="font-bold text-lg mb-4 text-silet-red">
                    {{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                </h4>
                <p class="text-gray-300 dark:text-gray-400 mb-4">
                    {{ $settings['site_description']->value ?? 'Media berita terkini dan terpercaya yang menyajikan informasi aktual dari Sumba.' }}
                </p>

                {{-- Tautan Sosial Media --}}
                <div class="flex space-x-4">
                    @foreach ([
        'facebook' => 'fab fa-facebook',
        'twitter' => 'fab fa-twitter',
        'instagram' => 'fab fa-instagram',
        'youtube' => 'fab fa-youtube',
    ] as $platform => $icon)
                        @php $urlKey = "social_{$platform}_url"; @endphp
                        @if (!empty($settings[$urlKey]->value))
                            <a href="{{ $settings[$urlKey]->value }}" aria-label="{{ ucfirst($platform) }}"
                                class="text-gray-400 hover:text-white transition" target="_blank"
                                rel="noopener noreferrer">
                                <i class="{{ $icon }} text-xl"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Kolom 2: Kategori --}}
            <div class="text-center">
                {{-- Mobile: Accordion --}}
                <div x-data="{ open: false }" class="md:hidden">
                    <h4 class="font-bold text-lg mb-4 flex justify-between items-center cursor-pointer"
                        @click="open = !open">
                        {{ __('KATEGORI') }}
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </h4>
                    <ul x-show="open" x-transition class="space-y-2">
                        @foreach ($footerCategories as $category)
                            <li>
                                <a href="{{ route('articles.category', $category->slug) }}"
                                    class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                        {{-- <li>
                            <a href="{{ route('categories.index') }}"
                                class="text-gray-300 dark:text-gray-400 hover:text-silet-red font-semibold">
                                ➤ Lihat Semua
                            </a>
                        </li> --}}
                    </ul>
                </div>

                {{-- Desktop: Grid --}}
                <div class="hidden md:block">
                    <h4 class="font-bold text-lg mb-4">{{ __('KATEGORI') }}</h4>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach ($footerCategories as $category)
                            <a href="{{ route('articles.category', $category->slug) }}"
                                class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kolom 3: Link Terkait --}}
            <div class="text-right">
                <h4 class="font-bold text-lg mb-4">{{ __('LINK TERKAIT') }}</h4>
                <ul class="space-y-2">
                    @foreach ($footerPages as $page)
                        <li>
                            <a href="{{ route('page.show', $page->slug) }}"
                                class="text-gray-300 dark:text-gray-400 hover:text-silet-red transition">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        {{-- Copyright --}}
        <div class="border-t border-gray-700 dark:border-gray-600 mt-8 pt-6 text-center">
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} {{ $settings['site_name']->value ?? 'SILET SUMBA' }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
