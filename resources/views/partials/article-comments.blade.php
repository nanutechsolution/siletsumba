@php
    $komentarDisetujui = $article->comments->where('status', 'approved');
@endphp

<section id="komentar" class="scroll-mt-24" aria-labelledby="judul-komentar">
    <div class="border-t-2 border-stone-900 pt-3 dark:border-stone-100">
        <h2 id="judul-komentar" class="text-sm font-semibold uppercase tracking-[0.14em]">
            Komentar ({{ $komentarDisetujui->count() }})
        </h2>
    </div>

    @if (session('success'))
    <div class="mt-4 rounded-lg border border-green-300 bg-green-50 p-3 text-sm text-green-900 dark:border-green-800 dark:bg-green-950 dark:text-green-200" role="status">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="mt-4 rounded-lg border border-red-300 bg-red-50 p-3 text-sm text-red-900 dark:border-red-800 dark:bg-red-950 dark:text-red-200" role="alert">
        {{ session('error') }}
    </div>
    @endif

    {{-- Form komentar --}}
    <form action="{{ route('comments.store') }}" method="POST" class="mt-5 space-y-4 rounded-xl bg-stone-100 p-4 dark:bg-stone-900">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">

        <p class="text-sm font-semibold">Tulis komentar</p>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="komentar-nama" class="mb-1 block text-sm font-medium">Nama</label>
                <input type="text" name="name" id="komentar-nama" value="{{ old('name') }}" required autocomplete="name"
                    class="w-full rounded-lg border-stone-300 bg-white text-base focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100">
                @error('name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="komentar-email" class="mb-1 block text-sm font-medium">Email</label>
                <input type="email" name="email" id="komentar-email" value="{{ old('email') }}" required autocomplete="email" inputmode="email"
                    class="w-full rounded-lg border-stone-300 bg-white text-base focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100">
                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">Tidak akan dipublikasikan.</p>
                @error('email')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="komentar-isi" class="mb-1 block text-sm font-medium">Komentar</label>
            <textarea name="body" id="komentar-isi" rows="4" required
                class="w-full rounded-lg border-stone-300 bg-white text-base focus:border-silet-red focus:ring-silet-red dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100">{{ old('body') }}</textarea>
            <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">Komentar ditinjau dulu sebelum tampil. Komentar berisi tautan dianggap spam.</p>
            @error('body')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="h-11 w-full rounded-full bg-silet-red px-6 text-sm font-semibold text-white hover:bg-red-700 sm:w-auto">
            Kirim komentar
        </button>
    </form>

    {{-- Daftar komentar --}}
    <div class="mt-6 divide-y divide-stone-200 dark:divide-stone-800">
        @forelse ($komentarDisetujui as $comment)
        <div class="flex gap-3 py-4">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-stone-200 text-sm font-semibold text-stone-700 dark:bg-stone-800 dark:text-stone-200" aria-hidden="true">
                {{ strtoupper(mb_substr($comment->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-baseline gap-x-2">
                    <p class="text-sm font-semibold">{{ $comment->name }}</p>
                    <p class="text-xs text-stone-500 dark:text-stone-400">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <p class="mt-1 whitespace-pre-line break-words text-[0.95rem] leading-relaxed text-stone-700 dark:text-stone-300">{{ $comment->body }}</p>
            </div>
        </div>
        @empty
        <p class="py-4 text-sm text-stone-500 dark:text-stone-400">Belum ada komentar. Jadilah yang pertama.</p>
        @endforelse
    </div>
</section>
