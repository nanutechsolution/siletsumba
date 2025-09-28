<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.articles.update', $article->slug) }}" method="POST" enctype="multipart/form-data" id="article-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Judul --}}
                        <div>
                            <label for="title" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                            @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            {{-- Kategori --}}
                            <div>
                                <label for="category_id" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                                <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-5">
                            {{-- Lokasi Singkat --}}
                            <div>
                                <label for="location_short" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi Singkat</label>
                                <input type="text" name="location_short" id="location_short" value="{{ old('location_short', $article->location_short) }}" class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Wewewa Barat, Sumba Barat Daya">
                            </div>
                        </div>
                        {{-- Breaking News --}}
                        <div class="mb-5">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" name="is_breaking" value="1" class="mt-1 h-5 w-5 text-blue-600 dark:text-blue-400 rounded border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-400" {{ old('is_breaking', $article->is_breaking) ? 'checked' : '' }}>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">Tandai sebagai Breaking
                                        News</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Jika dicentang, artikel ini akan muncul lebih menonjol di beranda dan diberi tanda
                                        "Breaking".
                                    </span>
                                </div>
                            </label>
                            @error('is_breaking')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @role('admin|editor')
                        <div x-data="{ status: '{{ old('status', $article->status) }}' }" class="mb-5">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Opsi Publikasi</h2>

                            <!-- Pilihan -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-2">
                                <!-- Draft -->
                                <label :class="status === 'draft'
            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/30 ring-2 ring-blue-400'
            : 'border-gray-300 dark:border-gray-600'" class="flex cursor-pointer items-center space-x-3 rounded-xl border p-4 shadow-sm transition hover:shadow-md">
                                    <input type="radio" name="status" value="draft" x-model="status" class="hidden" />
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">Simpan sebagai Draft</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Artikel tidak akan tampil ke publik</span>
                                    </div>
                                </label>

                                <!-- Terbit Sekarang -->
                                <label :class="status === 'published'
            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/30 ring-2 ring-blue-400'
            : 'border-gray-300 dark:border-gray-600'" class="flex cursor-pointer items-center space-x-3 rounded-xl border p-4 shadow-sm transition hover:shadow-md">
                                    <input type="radio" name="status" value="published" x-model="status" class="hidden" />
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">Terbit Sekarang</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Artikel langsung tampil setelah disimpan</span>
                                    </div>
                                </label>

                                <!-- Jadwalkan -->
                                <label :class="status === 'scheduled'
            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/30 ring-2 ring-blue-400'
            : 'border-gray-300 dark:border-gray-600'" class="flex cursor-pointer items-center space-x-3 rounded-xl border p-4 shadow-sm transition hover:shadow-md">
                                    <input type="radio" name="status" value="scheduled" x-model="status" class="hidden" />
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">Jadwalkan Terbit</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Artikel akan otomatis terbit di waktu tertentu</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Input Jadwal -->
                            <div x-show="status==='scheduled'" x-transition class="rounded-lg border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 p-4">
                                <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    Tanggal & Jam Terbit
                                </label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at', $article->scheduled_at ? $article->scheduled_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500 p-2">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Biarkan kosong jika tidak ingin menjadwalkan.
                                </p>
                            </div>
                        </div>
                        @endrole
                        {{-- Input Tags --}}
                        <div>
                            <label for="tags" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                            <select name="tags[]" id="tags" class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" multiple>
                                @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" @if (in_array($tag->id, old('tags', $article->tags->pluck('id')->toArray()))) selected @endif>
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
                            <div id="old-image-preview" class="w-full aspect-w-16 aspect-h-9 ">
                                @if ($article->hasMedia('images'))
                                @foreach ($article->getMedia('images') as $media)
                                <div class="relative group" data-id="{{ $media->id }}">
                                    <picture>
                                        <img src="{{ $media->getUrl('responsive') }}" class="w-full h-full object-cover object-center" alt="Gambar artikel">
                                    </picture>
                                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700 opacity-0 group-hover:opacity-100 transition delete-old-image">
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
                            <input type="file" name="new_images[]" id="new-images" multiple class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('new_images.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="mt-4 rounded-lg overflow-hidden shadow-sm w-full aspect-w-16 aspect-h-9 bg-gray-100 dark:bg-gray-800">
                                <div id="new-image-preview" class="w-full h-full object-cover object-center"></div>
                            </div>
                        </div>
                        {{-- Konten (Quill Editor) --}}
                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Konten Berita</label>
                            <div id="editor" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-96">
                            </div>
                            <input type="hidden" name="content" id="content-input" value="{{ old('content', $article->content) }}">
                            @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-between">
                            <x-submit-button text="Update" color="green" />
                            <a href="{{ route('admin.articles.index') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script>
        new TomSelect("#tags", {
            plugins: ['remove_button']
            , create: true
            , sortField: {
                field: "text"
                , direction: "asc"
            }
        , });

    </script>


    {{-- Quill.js CSS & JS --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Inisialisasi Quill Editor ---
            const quill = new Quill('#editor', {
                theme: 'snow'
                , placeholder: 'Tulis konten berita di sini...'
                , modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, false]
                        }]
                        , ['bold', 'italic', 'underline']
                        , ['link', 'image', 'video']
                        , [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }]
                        , ['clean']
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
                    img.className = 'w-full h-full object-cover hover:scale-105 transition-transform';
                    container.appendChild(img);
                    newImagePreviewContainer.appendChild(container);
                });
            });

        });

    </script>
</x-app-layout>
