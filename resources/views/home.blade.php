@extends('welcome')


@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Left (2/3) -->
        <div class="lg:col-span-2">
            @if ($hero)
                <!-- Featured Article -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="relative">
                        <a href="{{ route('articles.show', $hero->slug) }}">
                            <img src="{{ $hero->image_url ?? 'https://via.placeholder.com/300x200' }}"
                                alt="{{ $hero->title }}"
                                class="w-full h-[50vh] object-cover group-hover:opacity-90 transition duration-300">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                                <span class=" text-white px-3 py-1 rounded text-sm font-medium"
                                    style="background-color: {{ $hero->category->color }}">
                                    {{ $hero->category->name ?? 'Umum' }}
                                </span>
                                <h2 class="text-3xl font-bold text-white mt-2"> {!! $hero->title !!}</h2>
                                <p class="text-white mt-2">{{ Str::limit(strip_tags($hero->content), 150) }}</p>

                                <div class="flex items-center text-gray-300 text-sm mt-3">
                                    <span><i class="fas fa-user mr-1"></i>{{ $hero->author ?? 'Redaksi' }}</span>
                                    <span class="mx-3">•</span>
                                    <span><i class="fas fa-clock mr-1"></i> {{ $hero->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="flex overflow-x-auto scrollbar-hide border-b">
                    @foreach ($categories as $item)
                        <button data-slug="{{ $item->slug }}"
                            class="category-tab px-6 py-3 font-medium whitespace-nowrap">
                            {{ $item->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @foreach ($latestArticles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}"
                        class="group block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                        <!-- Image -->
                        <div class="relative h-48">
                            <img src="{{ $article->image_url ?? 'https://via.placeholder.com/300x200' }}"
                                alt="{{ $article->title }}"
                                class="w-full h-full object-cover group-hover:opacity-90 transition duration-300">

                            <span class="absolute top-2 left-2   text-white text-xs px-2 py-1 rounded font-semibold"
                                style="background-color: {{ $article->category->color }}; color: #fff;">
                                {{ $article->category->name ?? 'Umum' }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3
                                class="font-bold text-lg mb-2 text-gray-800 dark:text-white group-hover:text-tribun-red transition">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span><i class="far fa-clock mr-1"></i>{{ $article->created_at->diffForHumans() }}</span>
                                <span><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} dibaca</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $latestArticles->links() }}
            </div>

        </div>

        <!-- Sidebar Right (1/3) -->
        <div class="space-y-6">
            <!-- Trending News -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="font-bold text-lg mb-4 text-tribun-red border-b pb-2">
                    <i class="fas fa-fire mr-2"></i>TRENDING NOW
                </h3>
                <div class="space-y-3">
                    @foreach ($trending as $index => $article)
                        <div class="flex items-start space-x-3">
                            <span class="bg-tribun-red text-white text-xs px-2 py-1 rounded mt-1">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h4 class="font-medium hover:text-tribun-red cursor-pointer">
                                    {{ $article->title }}
                                </h4>
                                <p class="text-xs text-gray-500">
                                    {{ number_format($article->views) }} dibaca
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Latest News -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="font-bold text-lg mb-4 text-tribun-red border-b pb-2">
                    <i class="fas fa-clock mr-2"></i>TERBARU
                </h3>
                <div class="space-y-4">
                    @foreach ($latestArticles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="flex space-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition-colors">
                            <img src="{{ Storage::url($article->image_url) ?? 'https://via.placeholder.com/80x60' }}"
                                alt="{{ $article->title }}" class="w-20 h-15 object-cover rounded">
                            <div>
                                <h4 class="font-medium text-sm hover:text-tribun-red cursor-pointer">
                                    {{ $article->title }}
                                </h4>
                                <p class="text-xs text-gray-500">
                                    {{ $article->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>

            <!-- Advertisement -->
            <div class="bg-gray-100 rounded-lg p-4 text-center">
                <h4 class="text-sm text-gray-500 mb-2">ADVERTISEMENT</h4>
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/b259c087-ef16-40c8-87be-f9f713d14c87.png"
                    alt="Iklan sponsor produk teknologi terbaru" class="w-full h-48 object-cover rounded mb-2">
                <p class="text-xs text-gray-600">Dukung media independen dengan mendukung advertiser kami</p>
            </div>
        </div>
    </div>


    <script>
        document.querySelectorAll('.category-tab').forEach(btn => {
            btn.addEventListener('click', function() {
                let slug = this.dataset.slug;
                // hilangkan aktif dari semua tab
                document.querySelectorAll('.category-tab').forEach(b => {
                    b.classList.remove('border-b-2', 'border-tribun-red', 'text-tribun-red');
                    b.classList.add('text-gray-600');
                });
                // tab aktif
                this.classList.add('border-b-2', 'border-tribun-red', 'text-tribun-red');
                this.classList.remove('text-gray-600');
                // Fetch artikel via AJAX
                fetch(`/articles/category/${slug}`)
                    .then(res => res.json())
                    .then(data => {
                        let container = document.getElementById('articles-container');
                        container.innerHTML = '';
                        if (data.length === 0) {
                            container.innerHTML =
                                `<p class="text-gray-500">Belum ada artikel di kategori ini.</p>`;
                            return;
                        }
                        data.forEach(article => {
                            const colorClass = article.category?.color || 'bg-gray-500';
                            const categoryName = article.category?.name || 'Umum';
                            container.innerHTML += `
                        <a href="/articles/${article.slug}" class="block hover:shadow-lg transition-shadow duration-200">
                            <div class="article-card bg-white rounded-lg shadow-md overflow-hidden">
                                <img src="${article.image_url ?? 'https://via.placeholder.com/300x200'}"
                                    alt="${article.title}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                <span class="${colorClass} text-white px-2 py-1 rounded text-xs font-medium">
                                    ${categoryName}
                                </span>
                                <h3 class="font-bold text-lg mt-2 mb-2">${article.title}</h3>
                                <p class="text-gray-600 text-sm mb-3">
                                    ${article.content.substring(0, 100)}...
                                </p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>${new Date(article.created_at).toLocaleDateString()}</span>
                                    <span>${article.views} dibaca</span>
                    </div>
                </div>
            </div>
        </a>
    `;
                        });



                    });
            });
        });
    </script>
@endsection
