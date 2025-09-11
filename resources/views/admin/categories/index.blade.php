<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Kategori</h3>
                        <a href="{{ route('admin.categories.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Tambah Kategori
                        </a>
                    </div>

                    {{-- Tampilan Desktop (Tabel) --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table
                            class="min-w-full bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="py-2 px-4 border-b dark:border-gray-600 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="py-2 px-4 border-b dark:border-gray-600 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Warna</th>
                                    <th
                                        class="py-2 px-4 border-b dark:border-gray-600 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($categories as $category)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-2 px-4 whitespace-nowrap">{{ $category->name }}</td>
                                        <td class="py-2 px-4 text-center whitespace-nowrap">
                                            <span class="px-3 py-1 rounded text-white"
                                                style="background-color: {{ $category->color }};">
                                                {{ $category->name }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 text-center whitespace-nowrap">
                                            <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->slug) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 ml-4 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Tampilan Mobile (Cards) --}}
                    <div class="md:hidden space-y-4">
                        @forelse ($categories as $category)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $category->name }}
                                    </h4>
                                    <span style="background-color: {{ $category->color }};"
                                        class="px-3 py-1 rounded-full text-white text-sm">{{ $category->name }}</span>
                                </div>
                                <div class="mt-4 flex items-center justify-end text-sm font-medium">
                                    <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->slug) }}"
                                        method="POST" class="inline-block ml-4"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm text-center text-gray-500 dark:text-gray-400">
                                Tidak ada kategori.</div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
