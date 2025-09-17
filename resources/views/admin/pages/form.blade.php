<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
            {{ isset($page) ? 'Edit Halaman' : 'Tambah Halaman' }}
        </h1>

        <form action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}"
            method="POST">
            @csrf
            @if (isset($page))
                @method('PUT')
            @endif

            {{-- Judul --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-tribun-red focus:border-tribun-red"
                    required>
            </div>

            {{-- Konten (Quill Editor) --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konten</label>
                <div id="quill-editor" class="h-64 bg-white dark:bg-gray-800 dark:text-gray-200"></div>
                <textarea name="content" id="content" class="hidden">{{ old('content', $page->content ?? '') }}</textarea>
            </div>

            {{-- Status --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-tribun-red focus:border-tribun-red">
                    <option value="draft" {{ old('status', $page->status ?? '') == 'draft' ? 'selected' : '' }}>Draft
                    </option>
                    <option value="published" {{ old('status', $page->status ?? '') == 'published' ? 'selected' : '' }}>
                        Published</option>
                </select>
            </div>

            {{-- Tampilkan di Footer --}}
            <div class="mb-6 flex items-center space-x-2">
                <input type="checkbox" name="show_in_footer" value="1"
                    {{ old('show_in_footer', $page->show_in_footer ?? false) ? 'checked' : '' }}
                    class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-tribun-red focus:ring-tribun-red">
                <label class="text-sm text-gray-700 dark:text-gray-300">Tampilkan di Footer</label>
            </div>

            {{-- Submit --}}
            <x-submit-button text="{{ isset($page) ? 'Update' : 'Simpan' }}" color="blue" />
        </form>
    </div>

    {{-- Quill.js --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const quill = new Quill("#quill-editor", {
                theme: "snow", // Bisa ganti 'bubble' kalau mau lebih simple
                placeholder: "Tulis konten halaman di sini...",
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, 3, false]
                        }],
                        ["bold", "italic", "underline", "strike"],
                        [{
                            list: "ordered"
                        }, {
                            list: "bullet"
                        }],
                        ["link", "blockquote", "code-block", "image"],
                        ["clean"]
                    ]
                }
            });

            // Set initial content kalau edit
            quill.root.innerHTML = `{!! old('content', $page->content ?? '') !!}`;

            // Sync ke textarea sebelum submit
            document.querySelector("form").addEventListener("submit", function() {
                document.querySelector("#content").value = quill.root.innerHTML;
            });
        });
    </script>
</x-app-layout>
