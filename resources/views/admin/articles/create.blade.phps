<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Tambah Berita</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 space-y-6">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow space-y-6" x-data="{ openAI: false, tagsSelected: [] }">
            @csrf

            <!-- Section 1: Informasi Dasar -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 space-y-3">
                <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">1. Informasi Dasar</h3>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300">Judul <span
                            class="text-sm text-gray-400"
                            title="Masukkan judul berita yang jelas dan ringkas">?</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        placeholder="Contoh: Banjir Melanda Sumba"
                        class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300">Kategori <span
                            class="text-sm text-gray-400" title="Pilih kategori sesuai isi berita">?</span></label>
                    <select name="category_id"
                        class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_breaking" value="1"
                            class="form-checkbox h-5 w-5 text-blue-600 dark:text-blue-400">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Breaking News</span>
                    </label>
                </div>
            </div>

            <!-- Section 2: Lokasi & Kronologi -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 space-y-3">
                <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">2. Lokasi & Kronologi</h3>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300">Lokasi Singkat <span
                            class="text-sm text-gray-400"
                            title="Contoh: Wewewa Barat, Sumba Barat Daya">?</span></label>
                    <input type="text" name="location_short" placeholder="Contoh: Wewewa Barat, Sumba Barat Daya"
                        class="w-full border rounded px-3 py-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mt-2">Lokasi Detail <span
                            class="text-sm text-gray-400"
                            title="Contoh: Desa / Kecamatan / Kota, Sumba">?</span></label>
                    <input type="text" name="location" placeholder="Contoh: Desa Konda, Kecamatan Wewewa, Sumba"
                        class="w-full border rounded px-3 py-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mt-2">Fakta / Kronologi <span
                            class="text-sm text-gray-400"
                            title="Tuliskan kronologi atau data penting untuk berita">?</span></label>
                    <textarea name="facts" rows="4" placeholder="Tuliskan kronologi atau poin penting..."
                        class="w-full border rounded px-3 py-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required></textarea>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mt-2">Kutipan / Narasumber <span
                            class="text-sm text-gray-400"
                            title="Masukkan pernyataan langsung dari narasumber">?</span></label>
                    <textarea name="quotes" rows="3" placeholder="Contoh: 'Kami berusaha membantu warga,' kata Kepala Desa"
                        class="w-full border rounded px-3 py-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"></textarea>
                </div>
            </div>

            <!-- Section 3: Konten & AI -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 space-y-3">
                <h3
                    class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2 flex justify-between items-center">
                    3. Konten & AI
                    <button type="button" @click="openAI = !openAI"
                        class="text-sm text-blue-500 dark:text-blue-400 underline">Toggle AI</button>
                </h3>

                <label class="block font-medium text-gray-700 dark:text-gray-300">Konten Asli</label>
                <div id="editor"
                    class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-64 mt-1">
                </div>
                <textarea name="content" id="content" class="hidden"></textarea>

                <div x-show="openAI" x-transition class="mt-4 space-y-2">
                    <label class="block font-medium text-gray-700 dark:text-gray-300">Konten AI</label>
                    <div id="ai-editor"
                        class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-64 mt-1">
                    </div>
                    <textarea name="ai_content" id="ai-content" class="hidden"></textarea>
                    <button type="button" id="copy-ai-content-btn"
                        class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Salin Konten
                        AI</button>
                </div>
            </div>

            <!-- Section 4: Gambar & Tags -->
            <div class="pb-4 space-y-3">
                <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">4. Gambar & Tags</h3>

                <!-- Drag & Drop Gambar -->
                <div class="border-dashed border-2 border-gray-300 dark:border-gray-600 p-4 rounded text-center cursor-pointer"
                    @click="$refs.fileInput.click()" @dragover.prevent
                    @drop.prevent="let files = $event.dataTransfer.files; handleFiles(files)">
                    <p class="text-gray-500 dark:text-gray-400">Klik atau seret gambar ke sini (max 5MB)</p>
                    <input type="file" x-ref="fileInput" name="image" id="imageInput" class="hidden"
                        @change="handleFiles($event.target.files)">
                    <div id="imagePreview" class="mt-4"></div>
                </div>

                <!-- Tags Pilihan -->
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mt-2">Tags</label>
                    <select name="tags[]" multiple x-model="tagsSelected"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>

                    <!-- Preview Tag -->
                    <div class="mt-2 flex flex-wrap gap-2">
                        <template x-for="tag in tagsSelected" :key="tag">
                            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-sm"
                                x-text="$refs.select.options[$refs.select.selectedIndex].text"></span>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Section 5: Publikasi -->
            <div class="pb-4 space-y-3">
                <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">5. Publikasi</h3>
                <div class="flex items-center gap-6">
                    <label class="inline-flex items-center"><input type="radio" name="publish_option"
                            value="now" class="form-radio text-blue-600"> <span class="ml-2">Terbit
                            Sekarang</span></label>
                    <label class="inline-flex items-center"><input type="radio" name="publish_option"
                            value="schedule" class="form-radio text-blue-600"> <span class="ml-2">Jadwalkan
                            Terbit</span></label>
                </div>
                <input type="datetime-local" name="scheduled_at"
                    class="w-full border rounded px-3 py-2 mt-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-2">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('admin.articles.index') }}"
                    class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">Batal</a>
            </div>

        </form>
    </div>

    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function handleFiles(files) {
            if (!files || files.length === 0) return;
            const file = files[0];
            if (file.size > 5 * 1024 * 1024) {
                alert('Maks 5MB!');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = '';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-64 object-cover rounded shadow';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editorQuill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'image'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['clean']
                    ]
                }
            })
            const aiQuill = new Quill('#ai-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'image'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['clean']
                    ]
                }
            })
            const contentTextarea = document.getElementById('content');
            const aiTextarea = document.getElementById('ai-content');
            editorQuill.on('text-change', () => {
                contentTextarea.value = editorQuill.root.innerHTML
            })
            aiQuill.on('text-change', () => {
                aiTextarea.value = aiQuill.root.innerHTML
            })
            document.getElementById('copy-ai-content-btn').addEventListener('click', () => {
                editorQuill.root.innerHTML = aiQuill.root.innerHTML;
                alert('Konten AI disalin!')
            })
        })
    </script>
</x-app-layout>
