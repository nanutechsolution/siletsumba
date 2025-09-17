<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Halaman') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <a href="{{ route('admin.pages.create') }}"
            class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
            + Tambah Halaman
        </a>

        @if (session('success'))
            <div class="p-3 mb-4 text-green-800 bg-green-200 rounded-lg dark:bg-green-800 dark:text-green-100">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table untuk desktop --}}
        <div class="hidden sm:block overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Judul</th>
                        <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Slug</th>
                        <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Status</th>
                        <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr class="border-t dark:border-gray-600">
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $page->title }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $page->slug }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-lg 
                                    {{ $page->status == 'published' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.pages.edit', $page) }}"
                                    class="inline-block px-3 py-1 text-xs font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')"
                                        class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card untuk mobile --}}
        <div class="space-y-4 sm:hidden">
            @foreach ($pages as $page)
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $page->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Slug: {{ $page->slug }}</p>
                    <p class="mt-1">
                        <span
                            class="px-2 py-1 text-xs font-semibold rounded-lg 
                            {{ $page->status == 'published' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                            {{ ucfirst($page->status) }}
                        </span>
                    </p>
                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('admin.pages.edit', $page) }}"
                            class="flex-1 px-3 py-1 text-center text-xs font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')"
                                class="w-full px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $pages->links() }}
        </div>
    </div>
</x-app-layout>
