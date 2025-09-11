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
                        <button type="button" id="ai-generate-btn"
                            class="bg-purple-600 text-white py-1 px-3 rounded hover:bg-purple-700">Generate AI</button>
                        <button type="button" id="ai-tidy-btn"
                            class="bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700">Rapi-kan & Tambahkan
                            Konten</button>
                        <button type="button" id="ai-aida-btn"
                            class="bg-emerald-600 text-white py-1 px-3 rounded hover:bg-emerald-700">Generate
                            AIDA</button>
                        <button type="button" id="ai-copy-btn"
                            class="bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-600">Copy Hasil AI</button>
                        <button type="button" id="ai-critical-btn"
                            class="bg-red-600 text-white py-1 px-3 rounded hover:bg-red-700">Opini Kritis</button>
                        <button type="button" id="ai-silet-sumba-btn"
                            class="bg-indigo-600 text-white py-1 px-3 rounded hover:bg-indigo-700">Silet Sumba</button>
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
            // Konten asli
            const quill = new Quill('#editor', {
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
            const contentTextarea = document.getElementById('content');

            // Hasil AI
            const aiQuill = new Quill('#ai-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['link', 'image'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'align': []
                        }],
                        ['clean']
                    ]
                }
            });
            const aiTextarea = document.getElementById('ai-content');

            // Preview gambar
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

            // Tombol Loading
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
                        aiQuill.root.innerHTML = data.content;
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

            // Tombol AI
            document.getElementById('ai-generate-btn').addEventListener('click', async function() {
                const prompt = document.getElementById('title').value.trim();
                if (!prompt) return alert('Masukkan judul!');

                this.disabled = true;
                this.textContent = 'Membuat...';
                try {
                    const res = await fetch("{{ route('admin.articles.generate-content') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            prompt: `Bertindaklah sebagai jurnalis senior di sebuah kantor berita. Buatlah sebuah artikel berita lengkap tentang topik berikut: "${prompt}". 
                        Pastikan artikel memiliki:
                        - Judul menarik
                        - Minimal 3 paragraf
                        - Heading (H1/H2) untuk subjudul jika perlu
                        - Teks **bold** untuk hal penting
                        - Teks *italic* (garis miring) untuk penekanan
                        - Teks <u>underline</u> untuk highlight
                        - Paragraf otomatis menjorok (indentasi)
                        Gunakan bahasa yang lugas, informatif, dan akurat seperti gaya penulisan berita.
                        Hasil artikel dikembalikan dalam format yang bisa langsung di-copy ke editor HTML/contenteditable tanpa kehilangan format.`
                        })

                    });
                    const data = await res.json();
                    if (res.ok) setAIContent(data.content);
                    else alert('Gagal generate: ' + data.error);
                } catch (e) {
                    console.log(e);
                    alert('Kesalahan jaringan/server');
                } finally {
                    this.disabled = false;
                    this.textContent = 'Generate AI';
                }
            });
            // Fungsi untuk update AI content ke Quill
            function setAIContent(htmlContent) {
                aiQuill.root.innerHTML = htmlContent;
            }
            document.getElementById('ai-tidy-btn').addEventListener('click', function() {
                const original = quill.root.innerHTML.trim();
                if (!original) {
                    alert('Tulis konten asli dulu!');
                    return;
                }
                const instructions = `Anda adalah seorang jurnalis investigasi senior dengan pengalaman lebih dari 15 tahun. Tugas Anda adalah membuat artikel berita mendalam dan objektif berdasarkan topik: "${title}".
    Ikuti struktur "Piramida Terbalik" (Inverted Pyramid) dalam penulisan:
    1.  Paragraf pertama (lead) harus merangkum 5W+1H (Apa, Siapa, Kapan, Di mana, Mengapa, Bagaimana).
    2.  Paragraf berikutnya berisi detail penting yang mendukung lead.
    3.  Paragraf akhir berisi informasi tambahan atau konteks yang kurang penting.
    Batasan & Aturan Penulisan:
    -   Gunakan tag HTML berikut: <h1> untuk judul, <p> untuk paragraf, <b> untuk kata kunci.
    -   Gaya bahasa harus lugas, faktual, dan objektif.
    -   Panjang artikel minimal 400 kata.
    Pastikan tanggapan Anda hanya berupa HTML yang telah diformat, tanpa kalimat pengantar atau penutup.`;
                const prompt =
                    `${instructions}\nTeks asli untuk diolah: ${original}\nTanggapan Anda harus berisi HTML yang telah diformat, dan tidak ada teks lain.`;
                setButtonLoading(this, true);
                callAI(prompt, this);
            });

            document.getElementById('ai-aida-btn').addEventListener('click', function() {
                const original = quill.root.innerHTML.trim();
                const title = document.getElementById('title').value.trim();
                if (!title) {
                    alert('Masukkan judul!');
                    return;
                }
                const instructions = `Anda adalah seorang jurnalis investigasi senior dengan pengalaman lebih dari 15 tahun. Tugas Anda adalah membuat artikel berita mendalam dan objektif berdasarkan topik: "${title}".

Ikuti struktur "Piramida Terbalik" (Inverted Pyramid) dalam penulisan:
1. Paragraf pertama (lead) harus merangkum 5W+1H (Apa, Siapa, Kapan, Di mana, Mengapa, Bagaimana).
2. Paragraf berikutnya berisi detail penting yang mendukung lead.
3. Paragraf akhir berisi informasi tambahan atau konteks yang kurang penting.

Batasan & Aturan Penulisan:
- Gunakan tag HTML berikut: <h1> untuk judul, <p> untuk paragraf, <b> untuk kata kunci.
- Gaya bahasa harus lugas, faktual, dan objektif.
- Panjang artikel minimal 400 kata.
Pastikan tanggapan Anda hanya berupa HTML yang telah diformat, tanpa kalimat pengantar atau penutup.`;
                const prompt =
                    `${instructions}\nTeks asli untuk diolah: ${original} dengan judull: ${title}\nTanggapan Anda harus berisi HTML yang telah diformat, dan tidak ada teks lain.`;
                setButtonLoading(this, true);
                callAI(prompt, this);
            });
            document.getElementById('ai-critical-btn').addEventListener('click', function() {
                const title = document.getElementById('title').value.trim();
                const original = quill.root.innerHTML.trim();
                if (!title) return alert('Mohon masukkan judul terlebih dahulu.');
                const instructions = `Anda adalah seorang kolumnis opini senior dengan nada penulisan yang kritis dan tajam. Tuliskan sebuah artikel opini yang menganalisis dan memberikan pandangan kritis terhadap topik berikut: '${title}'.
                    Aturan penulisan:
                        -   Artikel harus memiliki argumen yang jelas dan didukung oleh setidaknya dua poin.
                        -   Gaya bahasa harus persuasif dan provokatif, namun tetap logis.
                        -   Gunakan tag HTML berikut: <h1> untuk judul, <p> untuk paragraf.
                    Pastikan tanggapan Anda hanya berupa HTML, tanpa kalimat pengantar atau penutup.`;
                const prompt =
                    `${instructions}\nTeks asli untuk diolah: ${original} dengan judull: ${title}\nTanggapan Anda harus berisi HTML yang telah diformat, dan tidak ada teks lain.`;
                setButtonLoading(this, true);
                callAI(prompt, this);
            });

            document.getElementById('ai-copy-btn').addEventListener('click', function() {
                const html = aiQuill.root.innerHTML;
                if (!html.trim()) return alert('Belum ada hasil AI!');
                navigator.clipboard.writeText(html).then(() => alert('Hasil AI berhasil dicopy!'));
            });


            const form = document.getElementById('article-form');
            form.addEventListener('submit', function(e) {
                console.log('Form submit ter-trigger!');
                document.getElementById('content').value = quill.root.innerHTML;
                document.getElementById('ai-content').value = aiQuill.root.innerHTML;
            });

        });
    </script>
</x-app-layout>
