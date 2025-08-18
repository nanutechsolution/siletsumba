<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silet Sumba - Berita, Budaya & Pariwisata Sumba</title>
    <meta name="description"
        content="Situs berita Silet Sumba menyajikan informasi terkini seputar Sumba, termasuk budaya, pariwisata, dan berita lokal.">
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <header>
        @include('partials.frontend-navbar')
    </header>


    <main class="min-h-screen pt-16">
        @yield('content')
    </main>
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Silet Sumba. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
    @vite('resources/js/app.js')
</body>

</html>
