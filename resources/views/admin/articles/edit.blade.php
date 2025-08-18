<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                    id="article-form">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div>
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                        <select name="category_id"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar Lama --}}
                    <div>
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Gambar Saat Ini</label>
                        <div id="old-image-preview" class="flex flex-wrap gap-4">
                            @foreach ($article->images as $image)
                                <div class="relative w-1/4" data-id="{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                        class="w-full h-auto rounded-lg shadow">
                                    <button type="button"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 delete-old-image">&times;</button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="delete_images[]" id="delete-images">
                    </div>

                    {{-- Tambah Gambar Baru --}}
                    <div>
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Tambah Gambar Baru</label>
                        <input type="file" name="images[]" id="new-images" multiple
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        @error('images.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div id="new-image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4"></div>
                    </div>

                    {{-- Konten --}}
                    <div>
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Konten</label>
                        <textarea name="content" rows="10"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required>{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow hover:shadow-lg transition">
                            Perbarui
                        </button>
                        <a href="{{ route('admin.articles.index') }}"
                            class="text-blue-500 hover:text-blue-700 font-semibold">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Hapus gambar lama
    const deleteOldButtons = document.querySelectorAll('.delete-old-image');
    let deleteIds = []; // array untuk semua gambar yang akan dihapus

    deleteOldButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const container = btn.closest('[data-id]');
            const id = container.dataset.id;

            if (!deleteIds.includes(id)) {
                deleteIds.push(id); // tambahkan id ke array
            }

            // update input hidden
            const deleteInput = document.getElementById('delete-images');
            deleteInput.value = deleteIds.join(',');
            // hapus elemen dari DOM
            container.remove();
        });
    });

    // Preview gambar baru
    let newFiles = [];
    const newInput = document.getElementById('new-images');
    const newPreview = document.getElementById('new-image-preview');

    newInput.addEventListener('change', function(event) {
        const files = Array.from(event.target.files);
        newFiles = newFiles.concat(files);

        newPreview.innerHTML = '';
        newFiles.forEach(file => {
            const container = document.createElement('div');
            container.className = 'relative w-full overflow-hidden rounded-lg shadow';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = file.name;
            img.className = 'w-full h-32 object-cover hover:scale-105 transition-transform';

            container.appendChild(img);
            newPreview.appendChild(container);
        });

        // Update input files
        const dataTransfer = new DataTransfer();
        newFiles.forEach(f => dataTransfer.items.add(f));
        newInput.files = dataTransfer.files;
    });
</script>
