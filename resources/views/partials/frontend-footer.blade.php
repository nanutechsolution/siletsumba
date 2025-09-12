<footer class="bg-tribun-dark text-white py-12 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h4 class="font-bold text-lg mb-4 text-tribun-red">{{ $settings['site_name']->value ?? 'SILET SUMBA' }}
                </h4>
                <p class="text-gray-300 dark:text-gray-400 mb-4">
                    {{ $settings['site_description']->value ?? 'Media berita terkini dan terpercaya yang menyajikan informasi aktual dari Sumba.' }}
                </p>

                {{-- Tautan Sosial Media Dinamis --}}
                <div class="flex space-x-4">
                    @if (isset($settings['social_facebook_url']->value))
                        <a href="{{ $settings['social_facebook_url']->value }}"
                            class="text-gray-400 hover:text-white transition" target="_blank">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                    @endif
                    @if (isset($settings['social_twitter_url']->value))
                        <a href="{{ $settings['social_twitter_url']->value }}"
                            class="text-gray-400 hover:text-white transition" target="_blank">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    @endif
                    @if (isset($settings['social_instagram_url']->value))
                        <a href="{{ $settings['social_instagram_url']->value }}"
                            class="text-gray-400 hover:text-white transition" target="_blank">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    @endif
                    @if (isset($settings['social_youtube_url']->value))
                        <a href="{{ $settings['social_youtube_url']->value }}"
                            class="text-gray-400 hover:text-white transition" target="_blank">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">{{ __('KATEGORI') }}</h4>
                <ul class="space-y-2">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('articles.category', $category->slug) }}"
                                class="text-gray-300 dark:text-gray-400 hover:text-tribun-red transition">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">{{ __('LINK TERKAIT') }}</h4>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="text-gray-300 dark:text-gray-400 hover:text-tribun-red transition">Tentang Kami</a>
                    </li>
                    <li><a href="#"
                            class="text-gray-300 dark:text-gray-400 hover:text-tribun-red transition">Redaksi</a></li>
                    <li><a href="#"
                            class="text-gray-300 dark:text-gray-400 hover:text-tribun-red transition">Pedoman Media</a>
                    </li>
                    <li><a href="#"
                            class="text-gray-300 dark:text-gray-400 hover:text-tribun-red transition">Karir</a></li>
                    <li><a href="#"
                            class="text-gray-300 dark:text-gray-400 hover:text-tribun-red transition">Iklan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">{{ __('KONTAK') }}</h4>
                @if (isset($settings['contact_address']->value))
                    <p class="text-gray-300 dark:text-gray-400 mb-2 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $settings['contact_address']->value }}</span>
                    </p>
                @endif
                @if (isset($settings['contact_phone']->value))
                    <p class="text-gray-300 dark:text-gray-400 mb-2 flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        <span>{{ $settings['contact_phone']->value }}</span>
                    </p>
                @endif
                @if (isset($settings['contact_email']->value))
                    <p class="text-gray-300 dark:text-gray-400 mb-2 flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>{{ $settings['contact_email']->value }}</span>
                    </p>
                @endif
            </div>
        </div>

        <div class="border-t border-gray-700 dark:border-gray-600 mt-8 pt-6 text-center">
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} {{ $settings['site_name']->value ?? 'SILET SUMBA' }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
