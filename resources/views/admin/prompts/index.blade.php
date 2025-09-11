<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Prompt AI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-4 flex justify-between items-center">
                        <a href="{{ route('admin.prompts.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            {{ __('Tambah Prompt Baru') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Tampilan untuk Desktop (Tabel) --}}
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tombol</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Deskripsi</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($prompts as $prompt)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $prompt->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span style="background-color: {{ $prompt->color }};"
                                                class="px-3 py-1 rounded-full text-white">{{ $prompt->button_text }}</span>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs overflow-hidden truncate">
                                            {{ $prompt->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('admin.prompts.edit', $prompt->id) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200 transition">{{ __('Edit') }}</a>
                                            <form action="{{ route('admin.prompts.destroy', $prompt->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus prompt ini?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200 ml-2 transition">{{ __('Hapus') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Tampilan untuk Mobile (Cards) --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($prompts as $prompt)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $prompt->name }}
                                    </h4>
                                    <span style="background-color: {{ $prompt->color }};"
                                        class="px-3 py-1 rounded-full text-white text-sm">{{ $prompt->button_text }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $prompt->description }}</p>
                                <div class="mt-4 flex items-center justify-end text-sm font-medium">
                                    <a href="{{ route('admin.prompts.edit', $prompt->id) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200 transition">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.prompts.destroy', $prompt->id) }}" method="POST"
                                        class="inline-block ml-4"
                                        onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus prompt ini?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200 transition">{{ __('Hapus') }}</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $prompts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
