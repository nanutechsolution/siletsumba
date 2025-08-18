<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Tema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div id="theme-preview-container"
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.theme.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="primary_color" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Warna
                            Primer</label>
                        <input type="color" name="primary_color" id="primary_color_input"
                            value="{{ old('primary_color', $theme->primary_color) }}" class="w-full h-12 rounded-lg"
                            required>
                        @error('primary_color')
                            <p class="text-red-500 dark:text-red-400 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="secondary_color" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Warna
                            Sekunder</label>
                        <input type="color" name="secondary_color" id="secondary_color_input"
                            value="{{ old('secondary_color', $theme->secondary_color) }}" class="w-full h-12 rounded-lg"
                            required>
                        @error('secondary_color')
                            <p class="text-red-500 dark:text-red-400 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="menu_background" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Latar
                            Belakang Menu</label>
                        <input type="color" name="menu_background" id="menu_background_input"
                            value="{{ old('menu_background', $theme->menu_background) }}" class="w-full h-12 rounded-lg"
                            required>
                        @error('menu_background')
                            <p class="text-red-500 dark:text-red-400 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Ambil elemen yang akan kita ubah warnanya
    const previewContainer = document.getElementById('theme-preview-container');
    const primaryColorInput = document.getElementById('primary_color_input');
    const secondaryColorInput = document.getElementById('secondary_color_input');
    const menuBackgroundInput = document.getElementById('menu_background_input');

    // Tambahkan event listener untuk setiap input warna
    primaryColorInput.addEventListener('input', (event) => {
        // Kita tidak bisa mengubah variabel CSS di sini. Sebagai gantinya, kita bisa mengubah warna preview.
        // Contoh: mengubah warna tombol atau teks
        previewContainer.style.borderColor = event.target.value;
    });

    secondaryColorInput.addEventListener('input', (event) => {
        // Contoh: mengubah warna teks di dalam container
        // previewContainer.style.color = event.target.value;
    });

    menuBackgroundInput.addEventListener('input', (event) => {
        // Mengubah warna latar belakang container
        previewContainer.style.backgroundColor = event.target.value;
    });
</script>
