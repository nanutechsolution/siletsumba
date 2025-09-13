<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Tag') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Success --}}
            @if (session('success'))
                <div
                    class="mb-4 rounded-lg border px-4 py-3 text-sm font-medium
                    bg-green-50 border-green-300 text-green-800
                    dark:bg-green-900 dark:border-green-700 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card --}}
            <div class="overflow-hidden rounded-lg shadow-sm
                        bg-white dark:bg-gray-800">
                <div class="p-6">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Daftar Tag</h3>
                        <a href="{{ route('admin.tags.create') }}"
                            class="rounded-md bg-blue-600 px-4 py-2 text-white font-semibold shadow
                                  hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400
                                  dark:focus:ring-blue-600 transition">
                            Tambah Tag
                        </a>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 border-b dark:border-gray-600">
                                        Nama
                                    </th>
                                    <th
                                        class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-200 border-b dark:border-gray-600">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $tag)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td
                                            class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200">
                                            {{ $tag->name }}
                                        </td>
                                        <td
                                            class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-center space-x-4">
                                            <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"
                                            class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada tag.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
