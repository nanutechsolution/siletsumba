@extends('welcome')

@section('content')
<nav aria-label="Breadcrumb" class="mb-4 text-xs text-stone-500 dark:text-stone-400">
    <a href="{{ url('/') }}" class="hover:text-silet-red">Beranda</a>
    <span aria-hidden="true">/</span>
    <span class="font-medium text-stone-700 dark:text-stone-200">{{ $page->title }}</span>
</nav>

<div class="grid gap-10 lg:grid-cols-12">
    <article class="lg:col-span-8">
        <div class="mx-auto max-w-[42rem] lg:mx-0">
            <h1 class="font-serif text-3xl font-bold leading-tight tracking-tight sm:text-4xl">{{ $page->title }}</h1>
            <div class="tenun-strip mt-4 w-24" aria-hidden="true"></div>

            <div class="prose prose-stone mt-6 max-w-none font-serif text-[1.0625rem] dark:prose-invert prose-headings:font-serif prose-headings:font-bold prose-p:leading-[1.8] prose-a:text-silet-red prose-img:rounded-lg">
                {!! $page->content !!}
            </div>
        </div>
    </article>

    <aside class="lg:col-span-4">
        <div class="lg:sticky lg:top-20">
            <div class="border-t-2 border-silet-red pt-3">
                <h2 class="text-sm font-semibold uppercase tracking-[0.14em]">Halaman lainnya</h2>
            </div>
            <ul class="divide-y divide-stone-200 dark:divide-stone-800">
                @foreach ($footerPages as $related)
                @if ($related->id !== $page->id)
                <li>
                    <a href="{{ route('page.show', $related->slug) }}" class="block py-3 text-base hover:text-silet-red">{{ $related->title }}</a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </aside>
</div>
@endsection
