<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Tag') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold">Daftar Tag</h3>
                    <a href="{{ route('admin.tags.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Tambah
                        Tag</a>
                </div>
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Nama</th>
                            <th class="py-2 px-4 border-b dark:border-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tags as $tag)
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700">{{ $tag->name }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700 text-center">
                                    <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Edit</a>
                                    <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 ml-4">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                    tag.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
