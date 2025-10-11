<!-- Popular News -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">BERITA POPULER</h2>
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach ($popular as $index => $pop)
            <a href="{{ route('articles.show', $pop->slug) }}"
                class="flex items-start space-x-3 py-3 px-2 rounded-lg hover:bg-red-50 dark:hover:bg-gray-700
                      transform hover:scale-105 hover:shadow-lg transition-all duration-200 ease-in-out">
                <span
                    class="bg-silet-red text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mt-1">
                    {{ $index + 1 }}
                </span>
                <p class="text-sm font-medium text-gray-800 dark:text-white truncate w-48">
                    {{ $pop->title }}
                </p>
            </a>
        @endforeach
    </div>
</div>

<!-- Latest News -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b pb-2">TERBARU</h2>
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach ($latest as $news)
            <a href="{{ route('articles.show', $news->slug) }}"
                class="block py-2 text-sm font-medium text-gray-800 dark:text-white hover:text-silet-red truncate">
                {{ $news->title }}
            </a>
        @endforeach
    </div>
</div>
