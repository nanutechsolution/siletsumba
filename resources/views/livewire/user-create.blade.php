<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Tambah Pengguna Baru
        </h2>

        <form wire:submit="submit" class="space-y-6">
            <!-- Nama & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input wire:model.live="name" id="name" type="text"
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input wire:model.live="email" id="email" type="email"
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password & Konfirmasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <div class="relative mt-1">
                        <input wire:model="password" id="password" type="{{ $type }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm pr-10 focus:ring focus:ring-blue-500">
                        <button type="button" wire:click="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 dark:text-gray-400">
                            <!-- SVG icon -->
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                    <input wire:model="password_confirmation" id="password_confirmation" type="{{ $type }}"
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                </div>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
                <select wire:model="role" id="role"
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                    <option value="writer">Writer</option>
                    <option value="editor">Editor</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Profil -->
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
                @endif
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                <textarea wire:model="bio" id="bio" rows="3"
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500"
                    placeholder="Tulis deskripsi singkat pengguna..."></textarea>
                @error('bio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Social Media -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Social Media</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-1">
                    <input wire:model="social_links.fb" type="url" placeholder="Facebook URL"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                    <input wire:model="social_links.ig" type="url" placeholder="Instagram URL"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                    <input wire:model="social_links.twitter" type="url" placeholder="Twitter URL"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring focus:ring-blue-500">
                </div>
            </div>

            <!-- Submit & Cancel -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">Simpan Pengguna</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
