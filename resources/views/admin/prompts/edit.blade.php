<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Prompt: {{ $prompt->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('admin.prompts.update', $prompt->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama (ID Unik)</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                value="{{ old('name', $prompt->name) }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="button_text" class="block text-sm font-medium text-gray-700">Teks Tombol</label>
                            <input type="text" name="button_text" id="button_text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                value="{{ old('button_text', $prompt->button_text) }}" required>
                            @error('button_text')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description', $prompt->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prompt_template" class="block text-sm font-medium text-gray-700">Template
                                Prompt</label>
                            <textarea name="prompt_template" id="prompt_template" rows="10"
                                class="mt-1 block w-full font-mono rounded-md border-gray-300 shadow-sm" required>{{ old('prompt_template', $prompt->prompt_template) }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">Gunakan placeholder seperti {title}, {facts},
                                {quotes}, {category}, {location}.</p>
                            @error('prompt_template')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Warna Tombol
                                (Hex)</label>
                            <input type="color" name="color" id="color"
                                class="mt-1 block w-20 h-10 rounded-md border-gray-300 shadow-sm"
                                value="{{ old('color', $prompt->color) }}" required>
                            @error('color')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Perbarui</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
