<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        KOMENTAR ({{ $article->comments()->where('status', 'approved')->count() }})
    </h2>

    <!-- Form Komentar -->
    <form action="{{ route('comments.store', $article->slug) }}" method="POST" class="mb-8 space-y-4">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">

        <div>
            <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama</label>
            <input type="text" name="name" id="name"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                required>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="body" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Komentar</label>
            <textarea name="body" id="body" rows="4"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                required></textarea>
            @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-silet-red text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                Kirim
            </button>
        </div>
    </form>

    <!-- Daftar Komentar -->
    <div class="space-y-6">
        @forelse ($article->comments->where('status', 'approved') as $comment)
            <div class="flex space-x-4">
                <img src="https://via.placeholder.com/50" alt="User" class="w-12 h-12 rounded-full object-cover">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-800 dark:text-white">{{ $comment->name }}</h4>
                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">{{ $comment->body }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">Belum ada komentar.</p>
        @endforelse
    </div>
</div>
