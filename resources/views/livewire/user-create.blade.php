<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Tambah Pengguna Baru
        </h2>

        <form wire:submit.prevent="submit" class="space-y-6">

            <!-- Nama & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input wire:model.defer="name" type="text" class="input">
                    @error('name')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input wire:model.defer="email" type="email" class="input">
                    @error('email')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <div class="relative mt-1">
                        <input wire:model.defer="password" type="{{ $type }}" class="input pr-10">
                        <button type="button" wire:click="togglePassword"
                            class="absolute right-0 top-1/2 -translate-y-1/2 px-3 text-gray-600">
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Konfirmasi Password</label>
                    <input wire:model.defer="password_confirmation" type="{{ $type }}" class="input">
                </div>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-medium">Role</label>
                <select wire:model.defer="role" class="input">
                    <option value="writer">Writer</option>
                    <option value="editor">Editor</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Profil -->
            <div>
                <label class="block text-sm font-medium">Foto Profil</label>
                <input wire:model="profile_photo_path" type="file">
                @if ($profile_photo_path)
                    <img src="{{ $profile_photo_path->temporaryUrl() }}" class="h-24 w-24 rounded-full mt-2">
                @endif
                @error('profile_photo_path')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-sm font-medium">Bio</label>
                <textarea wire:model.defer="bio" rows="3" class="input"></textarea>
                @error('bio')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Social Links -->
            <div>
                <label class="block text-sm font-medium">Social Links</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-1">
                    <input wire:model.defer="social_links.fb" type="url" placeholder="Facebook URL" class="input">
                    <input wire:model.defer="social_links.ig" type="url" placeholder="Instagram URL" class="input">
                    <input wire:model.defer="social_links.twitter" type="url" placeholder="Twitter URL"
                        class="input">
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="btn-blue">
                    <span wire:loading.remove>Submit</span>
                    <span wire:loading>Processing...</span>
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
