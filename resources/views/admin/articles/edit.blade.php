<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.articles.update', $article->slug) }}" method="POST"
                    enctype="multipart/form-data" id="article-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Judul --}}
                        <div>
                            <label for="title"
                                class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $article->title) }}"
                                class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Kategori --}}
                            <div>
                                <label for="category_id"
                                    class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                                <select name="category_id" id="category_id"
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

                            {{-- Status Publikasi --}}
                            <div class="flex items-center">
                                <label for="is_published" class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_published" id="is_published" value="1"
                                        class="sr-only peer"
                                        {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        id="is-published-label">
                                        {{ $article->is_published ? 'Terpublikasi' : 'Draft' }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Lokasi Singkat --}}
                            <div>
                                <label for="location_short"
                                    class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi Singkat</label>
                                <input type="text" name="location_short" id="location_short"
                                    value="{{ old('location_short', $article->location_short) }}"
                                    class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    placeholder="Wewewa Barat, Sumba Barat Daya">
                            </div>

                            {{-- Breaking News --}}
                            <div class="flex items-center">
                                <label for="is_breaking" class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_breaking" id="is_breaking" value="1"
                                        class="sr-only peer"
                                        {{ old('is_breaking', $article->is_breaking) ? 'checked' : '' }}>
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        id="is-breaking-label">
                                        {{ $article->is_breaking ? 'Breaking News' : 'Normal' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        {{-- Input Tags --}}
                        <div>
                            <label for="tags"
                                class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                            <select name="tags[]" id="tags"
                                class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                        @if (in_array($tag->id, old('tags', $article->tags->pluck('id')->toArray()))) selected @endif>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tags')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Gambar Saat Ini --}}
                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Gambar Saat Ini</label>
                            <div id="old-image-preview" class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @if ($article->hasMedia('images'))
                                    @foreach ($article->getMedia('images') as $media)
                                        <div class="relative group" data-id="{{ $media->id }}">
                                            <picture>
                                                <source srcset="{{ $media->getUrl('400') }}"
                                                    media="(max-width: 640px)">
                                                <source srcset="{{ $media->getUrl('800') }}"
                                                    media="(max-width: 1024px)">
                                                <img src="{{ $media->getUrl('thumb') }}" alt="Preview Gambar"
                                                    class="w-full h-auto rounded-lg shadow-md object-cover">
                                            </picture>
                                            <button type="button"
                                                class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700 opacity-0 group-hover:opacity-100 transition delete-media">
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">Belum ada gambar.</p>
                                @endif
                            </div>
                            <input type="hidden" name="delete_images" id="delete-images">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Tambah Gambar
                                Baru</label>
                            <input type="file" name="new_images[]" id="new-images" multiple
                                class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('new_images.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div id="new-image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4"></div>
                        </div>

                        {{-- Konten (Quill Editor) --}}
                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Konten Berita</label>
                            <div id="editor"
                                class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-96">
                            </div>
                            <input type="hidden" name="content" id="content-input"
                                value="{{ old('content', $article->content) }}">
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-between">
                            <x-submit-button text="Update" color="green" />
                            <a href="{{ route('admin.articles.index') }}"
                                class="text-blue-500 hover:text-blue-700 font-semibold">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Quill.js CSS & JS --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Inisialisasi Quill Editor ---
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tulis konten berita di sini...',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image', 'video'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['clean']
                ]
            }
        });

        // Set konten Quill dari input hidden
        const contentInput = document.getElementById('content-input');
        quill.root.innerHTML = contentInput.value;
        quill.root.classList.add('dark:text-gray-100');
        // Sinkronisasi konten Quill ke input hidden saat form disubmit
        const form = document.getElementById('article-form');
        form.addEventListener('submit', function() {
            contentInput.value = quill.root.innerHTML;
        });

        let deletedImageIds = [];
        const oldImagePreviewContainer = document.getElementById('old-image-preview');
        const deleteImagesContainer = document.getElementById('delete-images');

        oldImagePreviewContainer.addEventListener('click', function(e) {
            const deleteButton = e.target.closest('.delete-old-image');
            if (!deleteButton) return;

            const imageContainer = deleteButton.closest('[data-id]');
            const imageId = imageContainer.dataset.id;

            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                // Tambahkan ID ke array
                deletedImageIds.push(imageId);

                // Hapus semua hidden input lama
                deleteImagesContainer.innerHTML = '';

                // Buat hidden input baru per ID
                deletedImageIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_images[]';
                    input.value = id;
                    deleteImagesContainer.appendChild(input);
                });

                // Hapus preview di frontend
                imageContainer.remove();
            }
        });

        // --- Logika Preview Gambar Baru ---
        const newImagesInput = document.getElementById('new-images');
        const newImagePreviewContainer = document.getElementById('new-image-preview');

        newImagesInput.addEventListener('change', function(event) {
            newImagePreviewContainer.innerHTML = '';
            Array.from(event.target.files).forEach(file => {
                const container = document.createElement('div');
                container.className = 'relative w-full overflow-hidden rounded-lg shadow-md';
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                img.className = 'w-full h-32 object-cover hover:scale-105 transition-transform';
                container.appendChild(img);
                newImagePreviewContainer.appendChild(container);
            });
        });

        // --- Logika Toggle Status Publikasi ---
        const publishedToggle = document.getElementById('is_published');
        const publishedLabel = document.getElementById('is-published-label');
        publishedToggle.addEventListener('change', function() {
            publishedLabel.textContent = this.checked ? 'Terpublikasi' : 'Draft';
        });

        // --- Logika Toggle Breaking News ---
        const breakingToggle = document.getElementById('is_breaking');
        const breakingLabel = document.getElementById('is-breaking-label');
        breakingToggle.addEventListener('change', function() {
            breakingLabel.textContent = this.checked ? 'Breaking News' : 'Normal';
        });
        // Set initial text on page load
        const initialPublishedLabel = publishedToggle.closest('label').querySelector('span');
        initialPublishedLabel.textContent = publishedToggle.checked ? 'Terpublikasi' : 'Draft';
        const initialBreakingLabel = breakingToggle.closest('label').querySelector('span');
        initialBreakingLabel.textContent = breakingToggle.checked ? 'Breaking News' : 'Normal';
    });
</script>
