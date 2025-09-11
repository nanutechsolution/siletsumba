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
                    {{-- Gambar --}}
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Gambar</label>
                        <input type="file" name="images[]" id="images" multiple
                            class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <div id="image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4"></div>
                        @error('images.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
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
                        <button type="button" id="ai-generate-local-btn"
                            class="bg-purple-600 text-white py-1 px-3 rounded hover:bg-purple-700">Generate Berita
                            Lokal</button>
                        <button type="button" id="ai-silet-sumba-btn"
                            class="bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700">Silet Sumba</button>
                        <button type="button" id="ai-budaya-sumba-btn"
                            class="bg-emerald-600 text-white py-1 px-3 rounded hover:bg-emerald-700">Budaya
                            Sumba</button>
                        <button type="button" id="ai-opini-sumba-btn"
                            class="bg-red-600 text-white py-1 px-3 rounded hover:bg-red-700">Opini Sumba</button>
                        <button type="button" id="ai-aida-lokal-btn"
                            class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">AIDA Lokal</button>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-gray-700 dark:text-gray-300 mb-2">Konten AI</label>
                        <div id="ai-editor"
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded h-64">
                        </div>
                        <textarea name="ai_content" id="ai-content" class="hidden"></textarea>
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
            // ====== Editor utama ======
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

            // Restore old content jika ada
            const contentTextarea = document.getElementById('content');
            if (contentTextarea.value) editorQuill.root.innerHTML = contentTextarea.value;

            // ====== Editor AI ======
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

            const aiTextarea = document.getElementById('ai-content');
            if (aiTextarea.value) aiQuill.root.innerHTML = aiTextarea.value;

            // ====== Preview gambar ======
            let allFiles = [];
            const inputImages = document.getElementById('images');
            const previewContainer = document.getElementById('image-preview');

            inputImages.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                allFiles = allFiles.concat(files);
                previewContainer.innerHTML = '';
                allFiles.forEach(file => {
                    const div = document.createElement('div');
                    div.className = 'relative w-full overflow-hidden rounded-lg shadow-lg';
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.alt = file.name;
                    img.className = 'w-full h-32 object-cover hover:scale-105 transition-transform';
                    div.appendChild(img);
                    previewContainer.appendChild(div);
                });
                const dt = new DataTransfer();
                allFiles.forEach(f => dt.items.add(f));
                inputImages.files = dt.files;
            });

            // ====== Tombol Loading ======
            function setButtonLoading(button, loading = true) {
                if (loading) {
                    button.dataset.originalText = button.textContent;
                    button.textContent = 'Membuat...';
                    button.disabled = true;
                } else {
                    button.textContent = button.dataset.originalText;
                    button.disabled = false;
                }
            }

            // ====== Fungsi generate AI ======
            async function callAI(prompt, button) {
                try {
                    const res = await fetch("{{ route('admin.articles.generate-content') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
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
                    console.log(e);
                    alert('Kesalahan server/jaringan.');
                } finally {
                    setButtonLoading(button, false);
                }
            }

            // ====== Event tombol generate AI ======
            document.getElementById('ai-generate-local-btn').addEventListener('click', function() {
                const title = document.getElementById('title').value.trim();
                const categorySelect = document.querySelector('select[name="category_id"]');
                const category = categorySelect.options[categorySelect.selectedIndex].text;
                const location = document.getElementById('location').value.trim();
                const facts = document.getElementById('facts').value.trim();
                const quotes = document.getElementById('quotes').value.trim();
                if (!title) return alert('Masukkan judul!');
                const prompt = `Bertindaklah sebagai jurnalis profesional di Sumba yang menulis berita untuk media online.
                        Buat artikel berita dengan informasi berikut:
                        Judul: ${title}
                                Kategori: ${category}
                                Lokasi (jangan tulis di awal artikel): ${location || "Tidak disebutkan"}
                                Fakta / Kronologi: ${facts || "Tidak ada fakta tambahan"}
                                Kutipan / Narasumber (harus persis sama, jangan diubah): ${quotes || "Tidak ada kutipan"}
                                Instruksi penting:
                                - TIDAK BOLEH menulis lokasi dan domain di awal artikel
                                - Lead paragraph langsung masuk ke inti berita
                                - Minimal 3 paragraf, maksimal 5 paragraf
                                - Boleh ada subjudul jika relevan
                                - Gunakan <strong>, <em>, atau <u> sesuai konteks penting
                                - Gunakan bahasa jurnalistik profesional, lugas, akurat
                                - Sertakan konteks sosial atau dampak bagi masyarakat jika relevan
                                Output HANYA dalam format HTML siap publish, tanpa markdown (\`\`\`).`;

            setButtonLoading(this, true);
            callAI(prompt, this);
        });

        // ====== Event tombol generate AI Silet Sumba ======
        document.getElementById('ai-silet-sumba-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value.trim();
            const categorySelect = document.querySelector('select[name="category_id"]');
            const category = categorySelect.options[categorySelect.selectedIndex].text;
            const location = document.getElementById('location').value.trim();
            const facts = document.getElementById('facts').value.trim();
            const quotes = document.getElementById('quotes').value.trim();
            if (!title) return alert('Masukkan judul!');
            const prompt =
                `Bertindaklah sebagai jurnalis profesional di Sumba untuk website Silet Sumba.
                                                                                                        Tulisan ini harus sesuai gaya Silet Sumba: ringkas, tajam, tapi akurat.
                                                                                                        Judul: ${title}
                                                                                                        Kategori: ${category}
                                                                                                        Lokasi: ${location || "Tidak disebutkan"}
                                                                                                        Fakta / Kronologi: ${facts || "Tidak ada fakta tambahan"}
                                                                                                        Kutipan / Narasumber (harus persis sama, jangan diubah): ${quotes || "Tidak ada kutipan"}
                                                                                                        Petunjuk penulisan:
                                                                                                        - Lead paragraph memuat inti berita
                                                                                                        - 2-5 paragraf maksimal
                                                                                                        - Gunakan bold/italic/underline untuk highlight
                                                                                                        - Tambahkan subjudul jika perlu
                                                                                                        - Sertakan konteks lokal, adat, atau dampak sosial jika relevan
                                                                                                        Hasil kembalikan dalam format HTML/contenteditable siap dipublish.`;
            setButtonLoading(this, true);
            callAI(prompt, this);
        });

        // ====== Event tombol generate AI Budaya Sumba ======
        document.getElementById('ai-budaya-sumba-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value.trim();
            const categorySelect = document.querySelector('select[name="category_id"]');
            const category = categorySelect.options[categorySelect.selectedIndex].text;
            const location = document.getElementById('location').value.trim();
            const facts = document.getElementById('facts').value.trim();
            const quotes = document.getElementById('quotes').value.trim();
            if (!title) return alert('Masukkan judul!');

            const prompt =
                `Bertindaklah sebagai jurnalis Silet Sumba yang mengulas budaya Sumba. 
                                                                                            Buat artikel berita atau liputan budaya dengan gaya ringkas, tajam, dan menarik:
                                                                                            Judul: ${title}
                                                                                            Kategori: ${category}
                                                                                            Lokasi: ${location || "Tidak disebutkan"}
                                                                                            Fakta / Kronologi: ${facts || "Tidak ada fakta tambahan"}
                                                                                            Kutipan / Narasumber (harus persis sama, jangan diubah): ${quotes || "Tidak ada kutipan"}
                                                                                            
                                                                                            Buat artikel dengan:
                                                                                            - 2-5 paragraf, padat informasi
                                                                                            - Fokus pada aspek budaya, tradisi, seni, atau event lokal
                                                                                            - Gunakan kalimat tajam, lugas, dan sensasional
                                                                                            - Highlight poin penting dengan bold atau underline
                                                                                            Hasil kembalikan dalam format HTML/contenteditable.`;

            setButtonLoading(this, true);
            callAI(prompt, this);
        });

        // ====== Event tombol generate AI Opini Sumba ======
        document.getElementById('ai-opini-sumba-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value.trim();
            const categorySelect = document.querySelector('select[name="category_id"]');
            const category = categorySelect.options[categorySelect.selectedIndex].text;
            const location = document.getElementById('location').value.trim();
            const facts = document.getElementById('facts').value.trim();
            const quotes = document.getElementById('quotes').value.trim();
            if (!title) return alert('Masukkan judul!');

            const prompt =
                `Bertindaklah sebagai kolumnis atau penulis opini di Sumba. 
                                                                                            Buat artikel opini yang:
                                                                                            - Tajam, lugas, dan menarik
                                                                                            - Mencerminkan perspektif lokal Sumba
                                                                                            - Berdasarkan informasi berikut:
                                                                                                Judul: ${title}
                                                                                                Kategori: ${category}
                                                                                                Lokasi: ${location || "Tidak disebutkan"}
                                                                                                Fakta / Kronologi: ${facts || "Tidak ada fakta tambahan"}
                                                                                                Kutipan / Narasumber (harus persis sama, jangan diubah): ${quotes || "Tidak ada kutipan"}
                                                                                            - Panjang 2-5 paragraf
                                                                                            - Bisa menggunakan teks bold/italic untuk highlight pendapat penting
                                                                                            Hasil kembalikan dalam format HTML/contenteditable.`;
            setButtonLoading(this, true);
            callAI(prompt, this);
        });
        // ====== Event tombol generate AI AIDA Lokal ======
        document.getElementById('ai-aida-lokal-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value.trim();
            const categorySelect = document.querySelector('select[name="category_id"]');
            const category = categorySelect.options[categorySelect.selectedIndex].text;
            const location = document.getElementById('location').value.trim();
            const facts = document.getElementById('facts').value.trim();
            const quotes = document.getElementById('quotes').value.trim();
            if (!title) return alert('Masukkan judul!');

            const prompt =
                `Bertindaklah sebagai copywriter lokal di Sumba. Buat konten persuasif dengan metode AIDA (Attention, Interest, Desire, Action) menggunakan informasi berikut:
                                                                                            Judul / Produk / Event: ${title}
                                                                                            Kategori: ${category}
                                                                                            Lokasi: ${location || "Tidak disebutkan"}
                                                                                            Fakta / Kronologi: ${facts || "Tidak ada fakta tambahan"}
                                                                                            Kutipan / Narasumber (jika ada): ${quotes || "Tidak ada kutipan"}

                                                                                            Buat konten yang:
                                                                                            - Menarik perhatian pembaca (Attention)
                                                                                            - Membangkitkan minat (Interest)
                                                                                            - Membuat pembaca ingin berinteraksi atau membeli (Desire)
                                                                                            - Mendorong tindakan jelas (Action)
                                                                                            - Ringkas, lugas, dan sesuai konteks lokal Sumba
                                                                                            Hasil kembalikan dalam format HTML/contenteditable.`;
                setButtonLoading(this, true);
                callAI(prompt, this);
            });
            // ====== Submit form ======
            const form = document.getElementById('article-form');
            form.addEventListener('submit', function() {
                // Ambil konten dari Quill dan simpan ke textarea
                contentTextarea.value = editorQuill.root.innerHTML;
                aiTextarea.value = aiQuill.root.innerHTML;
            });
        });
    </script>

</x-app-layout>
