<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Moderasi Komentar') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Daftar Komentar</h3>

                    {{-- Tampilan Mobile (Cards) --}}
                    <div class="md:hidden space-y-4">
                        @forelse ($comments as $comment)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold">{{ $comment->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">di
                                        {{ $comment->article->title }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $comment->body }}</p>
                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">Status:
                                    @if ($comment->status === 'pending')
                                        <span class="text-yellow-600 dark:text-yellow-400 font-medium">Pending</span>
                                    @elseif ($comment->status === 'approved')
                                        <span class="text-green-600 dark:text-green-400 font-medium">Disetujui</span>
                                    @else
                                        <span class="text-red-600 dark:text-red-400 font-medium">Ditolak</span>
                                    @endif
                                </div>
                                <div class="mt-4 flex flex-wrap gap-2 justify-end text-sm font-medium">
                                    @if ($comment->status === 'pending')
                                        <form action="{{ route('admin.comments.approve', $comment->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded transition">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.comments.reject', $comment->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded transition">Tolak</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">Edit</a>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm text-center text-gray-500 dark:text-gray-400">
                                Tidak ada komentar.</div>
                        @endforelse
                    </div>

                    {{-- Tampilan Desktop (Tabel) --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Komentar</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Artikel</th>
                                    <th
                                        class="py-3 px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="py-3 px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($comments as $comment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                        <td class="py-4 px-4 whitespace-nowrap text-sm font-medium">{{ $comment->name }}
                                        </td>
                                        <td
                                            class="py-4 px-4 text-sm text-gray-500 dark:text-gray-400 max-w-sm truncate">
                                            {{ $comment->body }}</td>
                                        <td
                                            class="py-4 px-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <a href="{{ route('articles.show', $comment->article->slug) }}"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                                target="_blank">{{ $comment->article->title }}</a>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-center text-sm">
                                            @if ($comment->status === 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Pending</span>
                                            @elseif ($comment->status === 'approved')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Disetujui</span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-center text-sm font-medium">
                                            @if ($comment->status === 'pending')
                                                <form action="{{ route('admin.comments.approve', $comment->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-green-600 hover:text-green-800 dark:text-green-400 transition">{{ __('Setujui') }}</button>
                                                </form>
                                                <form action="{{ route('admin.comments.reject', $comment->id) }}"
                                                    method="POST" class="inline-block ml-4">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 transition">{{ __('Tolak') }}</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 transition ml-4">{{ __('Edit') }}</a>
                                            <form action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                method="POST" class="inline-block ml-4"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 transition">{{ __('Hapus') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada komentar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
