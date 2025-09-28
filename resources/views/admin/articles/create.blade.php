<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Berita') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-8 space-y-6">
                {{-- Form --}}
                <form id="article-form" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-5">
                        <label for="title" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Judul
                            Berita <span class="text-red-500">*</span></label>
                        <textarea name="title" id="title" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('title') }} </textarea>
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Breaking News --}}
                    <div class="mb-5">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="is_breaking" value="1" class="mt-1 h-5 w-5 text-blue-600 dark:text-blue-400 rounded border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-400">
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


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="location_short" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                Lokasi Singkat
                            </label>
                            <input type="text" name="location_short" id="location_short" value="{{ old('location_short') }}" placeholder="Wewewa Barat, Sumba Barat Daya" class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Gunakan nama daerah / kabupaten. Contoh: "Wewewa Barat, Sumba Barat Daya".
                            </p>
                            @error('location_short')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                Lokasi Detail
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Desa / Kecamatan / Kota, Sumba" class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Masukkan lokasi lengkap (desa / kecamatan / kota). AI akan menggunakan informasi ini
                                saat membuat konten.
                            </p>
                            @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Fakta / Kronologi --}}
                    <div class="mb-5">
                        <label for="facts" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">
                            Fakta / Kronologi
                        </label>
                        <textarea name="facts" id="facts" rows="4" placeholder="Masukkan kronologi, data, atau poin penting yang AI gunakan untuk menulis berita" class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('facts') }}</textarea>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Isi bagian ini dengan informasi yang jelas dan lengkap. AI akan menggunakan data ini untuk
                            membuat konten berita.
                        </p>
                        @error('facts')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kutipan / Narasumber --}}
                    <div class="mb-5">
                        <label for="quotes" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">
                            Kutipan / Narasumber
                        </label>
                        <textarea name="quotes" id="quotes" rows="3" placeholder="Masukkan pernyataan narasumber atau kutipan yang relevan" class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('quotes') }}</textarea>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Bisa diisi kutipan langsung dari narasumber atau pernyataan penting yang ingin ditampilkan
                            dalam berita.
                        </p>
                        @error('quotes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="tags" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Tags</label>
                        <select id="tags" name="tags[]" multiple>
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Ketik untuk menambahkan tag atau pilih dari daftar saran.
                        </p>
                        @error('tags')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Gambar</label>

                        <!-- Info & petunjuk -->
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            Pilih gambar untuk artikel. Maksimal 5MB, format jpeg/png/jpg/gif/svg.
                            Setelah dipilih, gambar akan tampil di preview di bawah.
                        </p>

                        <!-- File Input -->
                        <input type="file" name="image" id="imageInput" class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">

                        <!-- Preview -->
                        <div id="imagePreview" class="mt-4 rounded-lg overflow-hidden shadow-sm w-full aspect-w-16 aspect-h-9 bg-gray-100 dark:bg-gray-800">
                            <img id="previewImage" src="" alt="Preview Gambar" class="w-full h-full object-cover object-center hidden">
                        </div>

                        @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @role('admin|editor')
                    <div x-data="{ status: 'draft' }" class="mb-5">
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
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500 p-2">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Biarkan kosong jika tidak ingin menjadwalkan.
                            </p>
                        </div>
                    </div>

                    @endrole

                    {{-- Tombol AI --}}
                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            Generate Konten AI
                        </label>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            Pilih template yang sesuai, AI akan membuatkan draft konten untuk Anda.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4 overflow-x-auto">
                            @foreach ($prompts as $prompt)
                            <button type="button" class="py-2 px-4 rounded-lg text-white font-medium hover:opacity-90 transition shadow-sm hover:shadow-md flex-shrink-0" data-prompt-name="{{ $prompt->name }}" data-prompt-template="{{ $prompt->prompt_template }}" style="background-color: {{ $prompt->color ?? 'gray' }};">
                                {{ $prompt->button_text }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Konten Artikel --}}
                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Isi Berita <span class="text-red-500">*</span></label>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Ketik langsung di sini atau klik tombol AI untuk membuat draft otomatis.
                            Konten bisa dihasilkan dalam bahasa lain sesuai template.
                        </p>

                        <div id="editor" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg h-64">
                        </div>
                        <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Tombol Submit --}}
                    <div class="flex items-center justify-between">
                        <x-submit-button text="Simpan" color="blue" />
                        <a href="{{ route('admin.articles.index') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Batal</a>
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
            },
            // load old tags jika ada
            items: @json(old('tags', []))
        , });

    </script>

    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstError = document.querySelector('.text-red-500.text-sm');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth'
                    , block: 'center'
                });
            }
            // ====== Quill Editors ======
            const editorQuill = new Quill('#editor', {
                placeholder: 'Tulis isi berita disini...'
                , theme: 'snow'
                , modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }]
                        , ['bold', 'italic', 'underline', 'strike']
                        , ['link', 'image']
                        , [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }]
                        , ['clean']
                    ]
                }
            });
            const contentTextarea = document.getElementById('content');
            if (contentTextarea.value) editorQuill.root.innerHTML = contentTextarea.value;
            editorQuill.on('text-change', function() {
                contentTextarea.value = editorQuill.root.innerHTML;
            });
            editorQuill.root.classList.add('dark:text-gray-100');
            // ====== AI Generation Functions ======
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const aiButtons = document.querySelectorAll('[data-prompt-name]');

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
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': csrfToken
                        }
                        , body: JSON.stringify({
                            prompt
                        })
                    });

                    const data = await res.json();
                    if (res.ok) {
                        try {
                            let content = data.content;
                            content = content.replace(/^```html\s*/, '').replace(/```$/, '');
                            const delta = editorQuill.clipboard.convert(content);
                            editorQuill.setContents(delta, 'silent');
                            contentTextarea.value = editorQuill.root.innerHTML;

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
                    const promptName = this.dataset.promptName;
                    const title = document.getElementById('title').value.trim();
                    const categorySelect = document.querySelector('select[name="category_id"]');
                    const category = categorySelect.options[categorySelect.selectedIndex].text;
                    const location = document.getElementById('location').value.trim();
                    const facts = document.getElementById('facts').value.trim();
                    const quotes = document.getElementById('quotes').value.trim();
                    const content = document.getElementById('content').value.trim();

                    if (promptName === "rapikan_tambah_konten") {
                        if (!content) {
                            alert('Masukkan konten terlebih dahulu untuk dirapikan & ditambahkan!');
                            editorQuill.focus();
                            return;
                        }
                        const finalPrompts = promptTemplate.replace(/{konten}/g, content);
                        callAI(finalPrompts, this);
                    } else {
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
                    }

                });
            });
        });
        document.getElementById('article-form').addEventListener('submit', function(e) {
            // pastikan hidden textarea selalu ter-update
            contentTextarea.value = editorQuill.root.innerHTML;

            // optional: validasi kosong
            if (!contentTextarea.value.trim() || editorQuill.getText().trim() === '') {
                alert('Konten tidak boleh kosong!');
                e.preventDefault();
            }
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validasi ukuran maksimal 5MB
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran maksimal 5MB!');
                    imageInput.value = '';
                    previewImage.src = '';
                    previewImage.classList.add('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    previewImage.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            });
        });

    </script>

</x-app-layout>
