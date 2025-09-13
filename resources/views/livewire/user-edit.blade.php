<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Edit Pengguna
        </h2>
        <form wire:submit="submit" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input wire:model.live="name" id="name" type="text"
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring focus:ring-blue-500 px-3 py-2 text-sm shadow-sm">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input wire:model.live="email" id="email" type="email"
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring focus:ring-blue-500 px-3 py-2 text-sm shadow-sm">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <div class="relative mt-1">
                        <input wire:model="password" id="password" type="{{ $type }}"
                            autocomplete="new-password"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring focus:ring-blue-500 px-3 py-2 text-sm shadow-sm pr-10">
                        <button type="button" wire:click="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 dark:text-gray-400">
                            @if ($type == 'password')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.154 0 2.275.228 3.321.675M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6M3 3l6 6"></path>
                                </svg>
                            @endif
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                    <div class="relative mt-1">
                        <input wire:model="password_confirmation" id="password_confirmation" autocomplete="new-password"
                            type="{{ $type }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring focus:ring-blue-500 px-3 py-2 text-sm shadow-sm pr-10">
                    </div>
                </div>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
                <select wire:model="role" id="role"
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring focus:ring-blue-500 px-3 py-2 text-sm shadow-sm">
                    <option value="writer">Writer</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="profile_photo_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto
                    Profil</label>
                <input wire:model="profile_photo_path" id="profile_photo_path" type="file"
                    class="mt-1 w-full text-sm text-gray-700 dark:text-gray-200">
                @error('profile_photo_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                @if ($profile_photo_path)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Preview:</p>
                        <img src="{{ $profile_photo_path->temporaryUrl() }}" alt="Preview Foto"
                            class="h-24 w-24 object-cover rounded-full border border-gray-300 dark:border-gray-600">
                    </div>
                @else
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Foto Saat Ini:</p>
                        @if ($user->profile_photo_path)
                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Foto Profil Saat Ini"
                                class="h-24 w-24 object-cover rounded-full border border-gray-300 dark:border-gray-600">
                        @else
                            <div
                                class="h-24 w-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">Perbarui</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:underline">
                    Batal
                </a>
            </div>

            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                <div x-show="isUploading" class="mt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Mengunggah foto...</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                            :style="`width: ${progress}%`"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
