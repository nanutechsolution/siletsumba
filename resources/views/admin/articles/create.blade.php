<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-6">

                {{-- Alert AI --}}
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 dark:bg-yellow-900 dark:border-yellow-700 dark:text-yellow-300 px-4 py-3 rounded relative mb-6"
                    role="alert">
                    <strong class="font-bold">Peringatan!</strong>
                    <span class="block sm:inline">
                        Konten AI adalah draf. Periksa & verifikasi sebelum diterbitkan.
                    </span>
                </div>

                {{-- Form --}}
                <form id="article-form" action="{{ route('admin.articles.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label for="title"
                            class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                        <select name="category_id"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- is Breaking News --}}
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_breaking" value="1"
                                class="form-checkbox h-5 w-5 text-blue-600 dark:text-blue-400 rounded">
                            <span class="ml-2 text-gray-700 dark:text-gray-300 font-medium">Breaking News</span>
                        </label>
                        @error('is_breaking')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label for="location_short" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi
                            Singkat</label>
                        <input type="text" name="location_short" id="location_short"
                            value="{{ old('location_short') }}" placeholder="Wewewa Barat, Sumba Barat Daya"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        @error('location_short')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label for="location" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi
                            Detail</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            placeholder="Desa / Kecamatan / Kota, Sumba"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    </div>

                    {{-- Fakta / Kronologi --}}
                    <div class="mb-4">
                        <label for="facts" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Fakta /
                            Kronologi</label>
                        <textarea name="facts" id="facts" rows="4"
                            placeholder="Masukkan kronologi, data, atau poin penting yang AI gunakan untuk menulis berita"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('facts') }}</textarea>

                    </div>

                    {{-- Kutipan / Narasumber --}}
                    <div class="mb-4">
                        <label for="quotes" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Kutipan /
                            Narasumber</label>
                        <textarea name="quotes" id="quotes" rows="3"
                            placeholder="Masukkan pernyataan narasumber atau kutipan yang relevan"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('quotes') }}</textarea>

                    </div>

                    {{-- Input Tags --}}
                    <div>
                        <label for="tags" class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                        <select name="tags[]" id="tags"
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tags')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Gambar</label>
                        <input type="file" name="images[]" id="images" multiple
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <div id="image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4"></div>

                        {{-- Pesan error untuk seluruh input gambar --}}
                        @error('images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="is_published" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" id="is_published" value="1"
                                class="sr-only peer" {{ old('is_published', true) ? 'checked' : '' }}>
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                id="is-published-label">
                                {{ old('is_published') ? 'Terpublikasi' : 'Draft' }}
                            </span>
                        </label>
                    </div>

                    {{-- Konten Asli --}}
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Konten Asli</label>
                        <div id="editor"
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-64">
                        </div>
                        <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- Tombol AI --}}
                    <div class="flex flex-wrap gap-2 mb-4 overflow-x-auto">
                        @foreach ($prompts as $prompt)
                            <button type="button" class="py-1 px-3 rounded text-white hover:opacity-80 transition"
                                data-prompt-name="{{ $prompt->name }}"
                                data-prompt-template="{{ $prompt->prompt_template }}"
                                style="background-color: {{ $prompt->color ?? 'gray' }};">
                                {{ $prompt->button_text }}
                            </button>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Konten AI</label>
                        <div id="ai-editor"
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-64">
                        </div>
                        <textarea name="ai_content" id="ai-content" class="hidden"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="copy-ai-content-btn"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Salin Konten AI
                        </button>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow hover:shadow-lg transition">Simpan</button>
                        <a href="{{ route('admin.articles.index') }}"
                            class="text-blue-500 hover:text-blue-700 font-semibold">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to first error on page load
            const firstError = document.querySelector('.text-red-500.text-sm');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            // ====== Quill Editors ======
            const editorQuill = new Quill('#editor', {
                placeholder: 'Tulis konten disini...',
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['link', 'image'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['clean']
                    ]
                }
            });

            const aiQuill = new Quill('#ai-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['link', 'image'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        [{
                            align: []
                        }],
                        ['clean']
                    ]
                }
            });

            // Restore old content from textarea to Quill editors
            const contentTextarea = document.getElementById('content');
            const aiTextarea = document.getElementById('ai-content');
            if (contentTextarea.value) editorQuill.root.innerHTML = contentTextarea.value;
            if (aiTextarea.value) aiQuill.root.innerHTML = aiTextarea.value;

            // Automatically update hidden textareas when Quill content changes
            editorQuill.on('text-change', function() {
                contentTextarea.value = editorQuill.root.innerHTML;
            });
            aiQuill.on('text-change', function() {
                aiTextarea.value = aiQuill.root.innerHTML;
            });

            const inputImages = document.getElementById('images');
            const previewContainer = document.getElementById('image-preview');
            let allFiles = [];

            inputImages.addEventListener('change', function(event) {
                const newFiles = Array.from(event.target.files);
                allFiles = allFiles.concat(newFiles);
                updatePreviewAndInput();
            });

            previewContainer.addEventListener('click', function(event) {
                const deleteBtn = event.target.closest('.delete-preview-image');
                if (deleteBtn) {
                    const fileIndex = deleteBtn.dataset.index;
                    allFiles.splice(fileIndex, 1);
                    updatePreviewAndInput();
                }
            });

            function updatePreviewAndInput() {
                previewContainer.innerHTML = '';
                if (allFiles.length > 0) {
                    allFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const container = document.createElement('div');
                            container.className =
                                'relative w-full overflow-hidden rounded-lg shadow-md group';
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = file.name;
                            img.className = 'w-full h-32 object-cover';
                            const deleteBtn = document.createElement('button');
                            deleteBtn.type = 'button';
                            deleteBtn.innerHTML = '&times;';
                            deleteBtn.className =
                                'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition delete-preview-image';
                            deleteBtn.dataset.index = index;
                            container.appendChild(img);
                            container.appendChild(deleteBtn);
                            previewContainer.appendChild(container);
                        };
                        reader.readAsDataURL(file);
                    });
                }
                const dataTransfer = new DataTransfer();
                allFiles.forEach(f => dataTransfer.items.add(f));
                inputImages.files = dataTransfer.files;
            }

            // ====== AI Generation Functions ======
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const aiButtons = document.querySelectorAll('[data-prompt-name]');
            const copyAiContentBtn = document.getElementById('copy-ai-content-btn');

            function setButtonLoading(button, loading = true) {
                const loadingText = 'Membuat...';
                if (loading) {
                    button.dataset.originalText = button.textContent;
                    button.innerHTML = `
                     <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l2-2.647z"></path>
                    </svg>
                    ${loadingText}
                `;
                    button.disabled = true;
                    aiButtons.forEach(btn => {
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    });
                } else {
                    button.innerHTML = button.dataset.originalText;
                    button.disabled = false;
                    aiButtons.forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                }
            }

            async function callAI(prompt, button) {
                setButtonLoading(button, true);

                try {
                    const res = await fetch("{{ route('admin.articles.generate-content') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            prompt
                        })
                    });

                    const data = await res.json();
                    if (res.ok) {
                        try {
                            let content = data.content;
                            content = content.replace(/^```html\s*/, '').replace(/```$/, '');
                            const delta = aiQuill.clipboard.convert(content);
                            aiQuill.setContents(delta, 'silent');
                        } catch (err) {
                            console.error("Gagal set aiQuill content:", err);
                            alert("Gagal memuat konten AI.");
                        }
                    } else {
                        alert('Gagal generate: ' + data.error);
                    }
                } catch (e) {
                    console.error(e);
                    alert('Kesalahan server/jaringan.');
                } finally {
                    setButtonLoading(button, false);
                }
            }

            aiButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const promptTemplate = this.dataset.promptTemplate;
                    const title = document.getElementById('title').value.trim();
                    const categorySelect = document.querySelector('select[name="category_id"]');
                    const category = categorySelect.options[categorySelect.selectedIndex].text;
                    const location = document.getElementById('location').value.trim();
                    const facts = document.getElementById('facts').value.trim();
                    const quotes = document.getElementById('quotes').value.trim();

                    if (!title) {
                        alert('Masukkan judul terlebih dahulu!');
                        document.getElementById('title').focus();
                        return;
                    }
                    if (!location) {
                        alert('Masukkan Detail Lokasi terlebih dahulu!');
                        document.getElementById('location').focus();
                        return;
                    }
                    if (!facts) {
                        alert('Masukkan Fakta / Kronologi terlebih dahulu!');
                        document.getElementById('facts').focus();
                        return;
                    }

                    const finalPrompt = promptTemplate
                        .replace(/{title}/g, title)
                        .replace(/{category}/g, category)
                        .replace(/{location}/g, location || "Tidak disebutkan")
                        .replace(/{facts}/g, facts || "Tidak ada fakta tambahan")
                        .replace(/{quotes}/g, quotes || "Tidak ada kutipan");

                    callAI(finalPrompt, this);
                });
            });

            const publishedToggle = document.getElementById('is_published');
            const publishedLabel = document.getElementById('is-published-label');

            publishedToggle.addEventListener('change', function() {
                publishedLabel.textContent = this.checked ? 'Terpublikasi' : 'Draft';
            });

            publishedLabel.textContent = publishedToggle.checked ? 'Terpublikasi' : 'Draft';

            // Copy AI Content Button Logic
            copyAiContentBtn.addEventListener('click', function() {
                const aiContent = aiQuill.root.innerHTML;

                if (!aiContent.trim()) {
                    alert('Konten AI kosong, tidak ada yang bisa disalin!');
                    return;
                }

                editorQuill.root.innerHTML = aiContent;
                alert('Konten AI berhasil disalin ke editor utama!');
            });
        });
    </script>

</x-app-layout>
