@extends('welcome')

@section('content')
<div class="mx-auto py-2">
    @if(!$article->is_published)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
        <div class="font-semibold">⚠️ Mode Preview</div>
        <p>Artikel ini <strong>belum dipublikasikan</strong>.
            Jangan dibagikan ke publik sebelum statusnya tayang.</p>
    </div>
    @endif
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4" aria-label="Breadcrumb">
        <a href="{{ url('/') }}" class="hover:text-silet-red">Home</a>
        @if ($article->category?->parent)
        <span> &gt; </span>
        <a href="{{ route('home', $article->category->parent->slug) }}" class="hover:text-silet-red">
            {{ $article->category->parent->name }}
        </a>
        @endif
        <span> &gt; </span>
        <a href="{{ route('home', $article->category->slug) }}" class="hover:text-silet-red">
            {{ $article->category->name }}
        </a>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Article -->
        <div class="lg:col-span-3 space-y-6">
            @php
            $metaTitle = $article->title . ' - Silet Sumba';
            $shareUrl = url()->current();
            @endphp

            <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Meta Info -->
                <div class="flex items-center justify-between px-4 py-2  border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        @if ($article->user?->hasMedia('profile_photos'))
                        <img src="{{ $article->user->getFirstMediaUrl('profile_photos', 'small') }}" alt="{{ $article->user->name }}" class="w-8 h-8 rounded-full object-cover" loading="lazy">
                        @else
                        <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                        @endif
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <div><span class="font-semibold">Penulis:</span> {{ $article->user->name ?? 'Redaksi' }}
                            </div>
                            <div>
                                {{ \Carbon\Carbon::parse($article->scheduled_at ?? $article->created_at)->format('d F Y - H:i') }}
                                WITA</div>
                        </div>
                    </div>
                </div>
                <h1 class="p-4 space-y-6 text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white leading-snug">
                    {!! $article->title !!}
                </h1>
                {{-- Detail Article --}}
                @if ($article->hasMedia('images'))
                <div class="w-full max-w-4xl mx-auto rounded-lg overflow-hidden shadow-md bg-gray-100 dark:bg-gray-800">
                    <img src="{{ $article->getFirstMediaUrl('images', 'detail') }}" srcset="{{ $article->getFirstMedia('images')->getSrcset('detail') }}" sizes="(max-width: 640px) 100vw, (max-width: 1024px) 80vw, 1200px" alt="{{ $article->title }}" class="w-full h-auto object-contain object-center rounded-lg" loading="lazy" decoding="async">
                </div>
                @endif

                <!-- Interaction Bar -->
                <div class="bg-white dark:bg-gray-800 flex items-center justify-between px-4 py-2 shadow-sm rounded-lg mt-4">
                    <!-- Left: Views, Likes, Comments -->
                    <div class="flex items-center space-x-6 text-gray-600 dark:text-gray-400 text-sm">
                        <!-- Views -->
                        @auth
                        <div class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <span>{{ number_format($article->views) }}</span>
                        </div>
                        @endauth
                        <!-- Likes -->
                        <div class="flex items-center space-x-1">
                            @guest
                            <button onclick="document.getElementById('login-modal').classList.remove('hidden')" class="flex items-center space-x-1 hover:text-blue-500 transition p-1 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                </svg>

                                <span>{{ number_format($article->likes) }}</span>
                            </button>
                            @endguest
                            @auth
                            <form action="{{ route('articles.like', $article->slug) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center space-x-1 hover:text-blue-500 transition p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                    </svg>

                                    <span>{{ number_format($article->likes) }}</span>
                                </button>
                            </form>
                            @endauth
                        </div>

                        <!-- Comments -->
                        <div class="flex items-center space-x-1 cursor-pointer hover:text-blue-500 transition" onclick="document.getElementById('comments-section').scrollIntoView({ behavior: 'smooth' })">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            <span>{{ $article->comments_count ?? 0 }}</span>
                        </div>
                    </div>
                    @if($article->is_published)
                    <div x-data="{ open: false, copied: false }" class="relative">
                        <!-- Tombol Share -->
                        <button @click="open = true" class="flex items-center justify-center p-2 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transform hover:scale-105 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                            </svg>
                        </button>
                        <!-- Modal Share -->
                        <div x-show="open" x-transition.opacity x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div @click.outside="open = false" x-transition.scale class="bg-white dark:bg-gray-800 rounded-xl p-5 w-80 sm:w-96 shadow-xl transform transition-all">

                                <!-- Header Modal -->
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Bagikan</h2>
                                    <button @click="open = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Copy Link -->
                                <div class="flex mb-3 relative group">
                                    <input type="text" readonly value="{{ url()->current() }}" class="flex-1 p-2 border border-gray-300 rounded-l-lg text-sm dark:bg-gray-700 dark:text-gray-100">
                                    <button @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2000)" class="bg-green-600 text-white px-4 rounded-r-lg hover:bg-green-500 transition transform hover:scale-110">
                                        <span x-show="!copied">Copy</span>
                                        <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    <!-- Tooltip -->
                                    <div class="absolute top-0 -mt-6 left-1/2 -translate-x-1/2 bg-gray-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                        Klik untuk menyalin
                                    </div>
                                </div>

                                <!-- Toast -->
                                <div x-show="copied" x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-4 opacity-0" class="fixed bottom-5 left-1/2 -translate-x-1/2 bg-green-600 text-white px-4 py-2 w-full rounded shadow-md">
                                    Link berhasil disalin!
                                </div>

                                <!-- Share Buttons (SVG only) -->
                                <div class="grid grid-cols-4 gap-3 justify-items-center">
                                    <!-- WhatsApp -->
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="p-3 bg-green-50 rounded-lg text-green-600 transition transform hover:scale-125 hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48" class="w-6 h-6 fill-current">
                                            <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path>
                                            <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path>
                                            <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path>
                                            <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path>
                                            <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="p-3 bg-blue-50 rounded-lg text-blue-600 transition transform hover:scale-125 hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-6 h-6 fill-current">
                                            <path d="M279.14 288l14.22-92.66h-88.91V131.36c0-25.35 12.42-50.06 52.24-50.06H293V6.26S273.49 0 256.36 0c-73.22 0-121 44.38-121 124.72V195.3H86.24V288h49.12v224h100.2V288z" />
                                        </svg>
                                    </a>
                                    <!-- Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="p-3 bg-blue-50 rounded-lg text-blue-400 transition transform hover:scale-125 hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 fill-current">
                                            <path d="M459.4 151.7c.3 4.1 .3 8.2 .3 12.3 0 125-95.2 269-269 269-53.4 0-102.9-15.6-144.6-42.4 7.4 .9 14.8 1.2 22.4 1.2 44.3 0 85-15.1 117.4-40.8-41.3-.8-76.1-28-88.1-65.3 5.7 .9 11.3 1.4 17.3 1.4 8.2 0 16.2-1.1 23.8-3.2-43.2-8.7-75.7-46.7-75.7-92.4v-1.2c12.7 7.1 27.3 11.4 42.8 11.9-25.3-17-42-46-42-78.9 0-17.3 4.7-33.4 12.9-47.3 46 56.5 114.7 93.7 192 97.6-1.6-7-2.5-14.3-2.5-21.8 0-52.9 42.9-95.8 95.8-95.8 27.5 0 52.3 11.6 69.7 30.2 21.8-4.3 42.3-12.3 60.7-23.4-7.2 22.5-22.5 41.3-42.6 53.1 19.3-2.2 37.7-7.4 54.9-15-12.8 19-29 35.8-47.8 49.2z" />
                                        </svg>
                                    </a>
                                    <!-- Telegram -->
                                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="p-3 bg-blue-50 rounded-lg text-blue-500 transition transform hover:scale-125 hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" class="w-6 h-6 fill-current">
                                            <path d="M120 0C53.73 0 0 53.73 0 120s53.73 120 120 120 120-53.73 120-120S186.27 0 120 0zm58.2 81.6l-21.1 99.3c-1.6 7.1-5.8 8.9-11.7 5.5l-32.3-23.9-15.6 15c-1.7 1.7-3.1 3.1-6.4 3.1l2.3-32.4 59-53.3c2.6-2.3-.6-3.6-4-1.3l-73 45.9-31.5-9.8c-6.8-2.1-6.9-6.8 1.5-10.1l123-47.4c5.7-2.2 10.7 1.4 8.8 10z" />
                                        </svg>
                                    </a>
                                </div>

                                <!-- Close Button -->
                                <button @click="open = false" class="mt-5 w-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                    <button disabled class="flex items-center justify-center p-2 rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314M16.783 7.093a2.25 2.25 0 113.935-2.186 2.25 2.25 0 01-3.935 2.186zm0 12.814a2.25 2.25 0 103.935-2.186 2.25 2.25 0 00-3.935 2.186z" />
                        </svg>
                    </button>
                    @endif
                </div>

                <div id="login-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-80 text-center space-y-4">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Silakan login</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Anda harus login untuk menyukai artikel
                            ini.
                        </p>
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Login</a>
                        <button onclick="document.getElementById('login-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 text-sm">Tutup</button>
                    </div>
                </div>
                <!-- Content -->
                <div class="px-4  space-y-6">


                    <div class="prose dark:prose-invert max-w-none">
                        {!! $article->full_content_with_ads !!}
                    </div>
                    <!-- Tags -->
                    <section aria-label="tags">
                        @if ($article->tags->count())
                        <div class="flex flex-wrap gap-2 py-4">
                            @foreach ($article->tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm hover:bg-silet-red hover:text-white">
                                #{{ $tag->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </section>

                </div>
            </article>
            <!-- Comments -->
            @include('partials.article-comments', ['article' => $article])
        </div>
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            @include('partials.sidebar', ['popular' => $popular, 'latest' => $latest])
        </div>
    </div>
</div>
@endsection
