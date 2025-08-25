<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <!-- Nama Kategori -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            Nama Kategori
                        </label>
                        <input type="text" name="name" id="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                            dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required>
                        @error('name')
                            <p class="text-red-500 dark:text-red-400 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Warna Kategori -->
                    <div class="mb-4">
                        <label for="color" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            Warna Kategori
                        </label>
                        <input type="color" name="color" id="color" value="#000000"
                            class="w-16 h-10 border rounded focus:outline-none focus:ring-2 focus:ring-tribun-red">
                        @error('color')
                            <p class="text-red-500 dark:text-red-400 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
