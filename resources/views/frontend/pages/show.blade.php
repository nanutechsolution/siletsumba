@extends('welcome')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Konten Utama -->
        <article class="lg:col-span-3 prose dark:prose-invert max-w-none">
            <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>
            <div>{!! $page->content !!}</div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-4">
            <h2 class="font-semibold text-lg border-b pb-2 text-gray-700 dark:text-gray-200">
                {{ __('Baca Juga') }}
            </h2>
            <ul class="space-y-2">
                @foreach ($footerPages as $related)
                    @if ($related->id !== $page->id)
                        {{-- Jangan tampilkan halaman yg sedang dibuka --}}
                        <li>
                            <a href="{{ route('page.show', $related->slug) }}"
                                class="block text-sm text-gray-600 dark:text-gray-400 hover:text-silet-red transition dark:hover:text-silet-red">
                                {{ $related->title }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </aside>
    </div>
@endsection
