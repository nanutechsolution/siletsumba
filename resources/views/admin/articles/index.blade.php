<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Berita') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="mass-delete-form" action="{{ route('admin.articles.destroy.mass') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
                            <h3 class="text-2xl font-bold">Daftar Berita</h3>
                            <div class="flex flex-wrap items-center space-x-2">
                                <button type="submit" id="mass-delete-btn" disabled
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition opacity-50 cursor-not-allowed text-sm">
                                    Hapus Terpilih (<span id="selected-count">0</span>)
                                </button>
                                <a href="{{ route('admin.articles.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition text-sm">
                                    Tambah Berita
                                </a>
                            </div>
                        </div>
                        {{-- Tampilan Mobile (Cards) --}}
                        <div class="md:hidden space-y-4">
                            @forelse ($articles as $article)
                                <div
                                    class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm flex flex-col space-y-2">
                                    <div class="flex items-start space-x-3">
                                        <input type="checkbox" name="selected_articles[]" value="{{ $article->slug }}"
                                            class="article-checkbox mt-1 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-bold text-base text-gray-900 dark:text-gray-100 leading-tight">
                                                {{ $article->title }}</h4>
                                            @if (!$article->is_published && $article->scheduled_at)
                                                <span
                                                    class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Terbit
                                                    {{ \Carbon\Carbon::parse($article->scheduled_at)->diffForHumans([
                                                        'parts' => 1,
                                                        'short' => true,
                                                        'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                                                    ]) }}
                                                </span>
                                            @endif
                                            <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">Kategori:
                                                {{ $article->category->name }}</p>


                                            @if ($article->is_published)
                                                <span
                                                    class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Dipublikasikan
                                                </span>
                                            @else
                                                <span
                                                    class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div
                                        class="flex flex-wrap items-center justify-between text-sm font-medium pt-3 border-t dark:border-gray-600">
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded transition"
                                            title="Lihat Berita">
                                            Lihat
                                        </a>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.articles.edit', $article->slug) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition"
                                                title="Edit Berita">
                                                Edit
                                            </a>
                                            @can('admin|editor')
                                                <form action="{{ route('admin.articles.destroy', $article->slug) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus berita ini?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition"
                                                        title="Hapus Berita"> Hapus
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada berita.</div>
                            @endforelse
                        </div>

                        {{-- Tampilan Desktop (Tabel) --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 w-10">
                                            <input type="checkbox" id="select-all-checkbox"
                                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        </th>
                                        <th
                                            class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Judul</th>
                                        <th
                                            class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Kategori</th>
                                        <th
                                            class="py-3 px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($articles as $article)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                            <td class="py-4 px-4 w-10">
                                                <input type="checkbox" name="selected_articles[]"
                                                    value="{{ $article->slug }}"
                                                    class="article-checkbox rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                            </td>
                                            <td class="py-4 px-4 whitespace-nowrap text-sm font-medium">
                                                {{ $article->title }}</td>
                                            {{-- is_published use background color --}}

                                            <td class="py-4 px-4 whitespace-nowrap text-sm">
                                                @if ($article->is_published)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                        Dipublikasikan
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                        Draft
                                                    </span>
                                                @endif
                                            </td>
                                            <td
                                                class="py-4 px-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $article->category->name }}
                                            </td>
                                            <td class="py-4 px-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="{{ route('articles.show', $article->slug) }}"
                                                    class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200 mr-4 transition">{{ __('Preview') }}</a>
                                                <a href="{{ route('admin.articles.edit', $article->slug) }}"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition">{{ __('Edit') }}</a>
                                                <form action="{{ route('admin.articles.destroy', $article->slug) }}"
                                                    method="POST" class="inline-block ml-4"
                                                    onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus berita ini?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 transition">{{ __('Hapus') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                                berita.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $articles->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const articleCheckboxes = document.querySelectorAll('.article-checkbox');
            const massDeleteBtn = document.getElementById('mass-delete-btn');
            const selectedCountSpan = document.getElementById('selected-count');

            function updateSelectedCount() {
                const checkedCount = document.querySelectorAll('.article-checkbox:checked').length;
                selectedCountSpan.textContent = checkedCount;
                massDeleteBtn.disabled = checkedCount === 0;
                massDeleteBtn.classList.toggle('opacity-50', checkedCount === 0);
                massDeleteBtn.classList.toggle('cursor-not-allowed', checkedCount === 0);
            }

            selectAllCheckbox.addEventListener('change', function() {
                articleCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            articleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(articleCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    updateSelectedCount();
                });
            });

            massDeleteBtn.addEventListener('click', function(event) {
                if (!confirm('Apakah Anda yakin ingin menghapus artikel yang dipilih?')) {
                    event.preventDefault();
                }
            });

            updateSelectedCount();
        });
    </script>
</x-app-layout>
