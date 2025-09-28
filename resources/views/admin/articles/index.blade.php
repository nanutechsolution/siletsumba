<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Berita') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert --}}
            @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Form Mass Delete --}}
                    <form id="mass-delete-form" action="{{ route('admin.articles.destroy.mass') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                            <div class="flex items-center space-x-2">
                                @role(['admin','editor'])
                                <button type="submit" id="mass-delete-btn" disabled class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition opacity-50 cursor-not-allowed text-sm">
                                    Hapus Terpilih (<span id="selected-count">0</span>)
                                </button>
                                @endrole
                                <a href="{{ route('admin.articles.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition text-sm">
                                    Tambah Berita
                                </a>
                            </div>
                        </div>

                        {{-- Tampilan Mobile (Cards) --}}
                        <div class="md:hidden space-y-4">
                            @forelse ($articles as $article)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" name="selected_articles[]" value="{{ $article->slug }}" class="article-checkbox mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

                                    <div class="flex-1">
                                        <h4 class="font-bold text-base text-gray-900 dark:text-gray-100">
                                            {{ $article->title }}
                                        </h4>

                                        {{-- Status --}}
                                        @if ($article->is_published)
                                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Dipublikasikan
                                        </span>
                                        @else
                                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Draft
                                        </span>
                                        @endif

                                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                                            Kategori: {{ $article->category->name }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Aksi Mobile --}}
                                <div class="flex flex-wrap justify-end space-x-2 mt-3 relative z-10">
                                    <a href="{{ route('admin.articles.edit', $article->slug) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm inline-block">
                                        Edit
                                    </a>

                                    @if ($article->is_published)
                                    <a href="{{ route('articles.show', $article->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm inline-block">
                                        Lihat
                                    </a>
                                    @if (auth()->user()->hasRole(['admin','editor']))
                                    <form action="{{ route('admin.articles.unpublish', $article->slug) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mengembalikan ke draft?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                            Draft
                                        </button>
                                    </form>
                                    @endif
                                    @else
                                    <a href="#" onclick="showDraftModal(event)" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm inline-block">
                                        Lihat
                                    </a>
                                    @endif
                                    {{-- @if (auth()->user()->hasRole(['admin','editor']))
                                    <form action="{{ route('admin.articles.destroy', $article->slug) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif --}}
                                </div>

                            </div>
                            @empty
                            <div class="p-4 text-center text-gray-500 dark:text-gray-300">
                                Tidak ada berita.
                            </div>
                            @endforelse
                        </div>

                        {{-- Tampilan Desktop (Tabel) --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 w-10">
                                            <input type="checkbox" id="select-all-checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Judul</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategori</th>
                                        <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($articles as $article)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-4 px-4 w-10">
                                            <input type="checkbox" name="selected_articles[]" value="{{ $article->slug }}" class="article-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </td>
                                        <td class="py-4 px-4 text-sm font-medium">{{ $article->title }}</td>
                                        <td class="py-4 px-4 text-sm">
                                            @if ($article->is_published)
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Dipublikasikan
                                            </span>
                                            @else
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">{{ $article->category->name }}</td>
                                        <td class="py-4 px-2 text-center text-sm space-x-2">
                                            <a href="{{ route('admin.articles.edit', $article->slug) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </a>

                                            @if ($article->is_published)
                                            <a href="{{ route('articles.show', $article->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                Lihat
                                            </a>

                                            @if (auth()->user()->hasRole(['admin','editor']))
                                            <form action="{{ route('admin.articles.unpublish', $article->slug) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengembalikan ke draft?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                                    Draft
                                                </button>
                                            </form>
                                            @endif
                                            @else
                                            <a href="#" onclick="showDraftModal(event)" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                Lihat
                                            </a>
                                            @endif

                                            @if (auth()->user()->hasRole(['admin','editor']))
                                            <form action="{{ route('admin.articles.destroy', $article->slug) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada berita.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Draft --}}
    <div id="draft-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div class="inline-block bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Artikel Belum Dipublikasikan</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Artikel ini masih berstatus <b>Draft</b> dan belum bisa dilihat publik.
                </p>
                <div class="mt-4 flex justify-end">
                    <button onclick="closeModal()" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDraftModal(event) {
            event.preventDefault();
            document.getElementById('draft-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('draft-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all-checkbox');
            const checkboxes = document.querySelectorAll('.article-checkbox');
            const deleteBtn = document.getElementById('mass-delete-btn');
            const countSpan = document.getElementById('selected-count');

            function updateCount() {
                const checked = document.querySelectorAll('.article-checkbox:checked').length;
                countSpan.textContent = checked;
                deleteBtn.disabled = checked === 0;
                deleteBtn.classList.toggle('opacity-50', checked === 0);
                deleteBtn.classList.toggle('cursor-not-allowed', checked === 0);
            }

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateCount();
            });

            checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

            updateCount();
        });

    </script>
</x-app-layout>
