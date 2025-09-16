    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold">Daftar Pengguna</h3>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                    <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
                </a>
            </div>

            <div class="mb-4">
                <input wire:model.live="search" type="text" placeholder="Cari pengguna..."
                    class="w-full md:w-1/3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Pengguna</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Peran</th>
                            <th
                                class="py-3 px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <td class="py-4 px-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($user->profile_photo_path)
                                                <img class="h-10 w-10 rounded-full"
                                                    src="{{ Storage::url($user->profile_photo_path) }}"
                                                    alt="{{ $user->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-center text-sm font-medium">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }} dark:bg-gray-600 dark:text-gray-200">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition">{{ __('Edit') }}</a>
                                    <button wire:click="delete({{ $user->id }})"
                                        onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus pengguna ini?') }}')"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 transition ml-4">{{ __('Hapus') }}</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                    pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4">
                @forelse ($users as $user)
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center mb-2 space-x-3">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if ($user->profile_photo_path)
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
                                @else
                                    <div
                                        class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-base text-gray-900 dark:text-gray-100 leading-tight">
                                    {{ $user->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 truncate">{{ $user->email }}</p>
                            </div>
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }} dark:bg-gray-600 dark:text-gray-200">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="mt-4 flex items-center justify-end text-sm font-medium">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 transition">{{ __('Edit') }}</a>
                            <button wire:click="delete({{ $user->id }})"
                                onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus pengguna ini?') }}')"
                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition ml-4">{{ __('Hapus') }}</button>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm text-center text-gray-500 dark:text-gray-400">
                        Tidak ada pengguna.</div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
