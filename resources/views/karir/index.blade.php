@extends('welcome')
@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-sumba-green to-sumba-gold text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Karir di Sumba</h1>
            <p class="text-xl mb-8">Temukan Peluang Kerja dan Mengembangkan Karir di Pulau Sumba</p>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                    <i class="fas fa-briefcase text-3xl mb-2"></i>
                    <h3 class="font-bold">250+</h3>
                    <p>Lowongan Tersedia</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                    <i class="fas fa-building text-3xl mb-2"></i>
                    <h3 class="font-bold">50+</h3>
                    <p>Perusahaan Mitra</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                    <i class="fas fa-graduation-cap text-3xl mb-2"></i>
                    <h3 class="font-bold">15+</h3>
                    <p>Program Pelatihan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Lowongan</label>
                <div class="relative">
                    <input type="text" placeholder="Posisi, perusahaan, atau kata kunci..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-tribun-red">
                    <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <select
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-tribun-red">
                    <option value="">Semua Lokasi</option>
                    <option value="waikabubak">Waikabubak</option>
                    <option value="waingapu">Waingapu</option>
                    <option value="west-sumba">Sumba Barat</option>
                    <option value="east-sumba">Sumba Timur</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-tribun-red">
                    <option value="">Semua Kategori</option>
                    <option value="hospitality">Hospitality & Pariwisata</option>
                    <option value="education">Pendidikan</option>
                    <option value="healthcare">Kesehatan</option>
                    <option value="government">Pemerintahan</option>
                    <option value="agriculture">Pertanian</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Job Categories -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-center mb-8">Kategori Pekerjaan</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="category-badge bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg cursor-pointer">
                <i class="fas fa-hotel text-3xl text-sumba-green mb-3"></i>
                <h3 class="font-semibold">Hospitality</h3>
                <p class="text-sm text-gray-600">125 lowongan</p>
            </div>
            <div class="category-badge bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg cursor-pointer">
                <i class="fas fa-graduation-cap text-3xl text-tribun-blue mb-3"></i>
                <h3 class="font-semibold">Pendidikan</h3>
                <p class="text-sm text-gray-600">68 lowongan</p>
            </div>
            <div class="category-badge bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg cursor-pointer">
                <i class="fas fa-heartbeat text-3xl text-tribun-red mb-3"></i>
                <h3 class="font-semibold">Kesehatan</h3>
                <p class="text-sm text-gray-600">42 lowongan</p>
            </div>
            <div class極端な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。 <div
                class="category-badge bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg cursor-pointer">
                <i class="fas fa-tractor text-3xl text-sumba-brown mb-3"></i>
                <h3 class="font-semibold">Pertanian</h3>
                <p class="text-sm text-gray-600">35 lowongan</p>
            </div>
        </div>
    </div>

    <!-- Featured Jobs -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Lowongan Terbaru</h2>
            <a href="#" class="text-tribun-red hover:underline">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Job 1 -->
            <div class="job-card bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-tribun-red mb-2">Manajer Hotel</h3>
                        <p class="text-gray-600">PT. Sumba Hospitality Group</p>
                    </div>
                    <img src="https://placehold.co/60x60" alt="Logo PT. Sumba Hospitality Group"
                        class="w-12 h-12 object-cover rounded">
                </div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-sumba-green/10 text-sumba-green px-3 py-1 rounded-full text-sm">Waikabubak</span>
                    <span class="bg-tribun-blue/10 text-tribun-blue px-3 py-1 rounded-full text-sm">Full-time</span>
                    <span class="bg-tribun-red/10 text-tribun-red px-3 py-1 rounded-full text-sm">Rp 8-12
                        Juta</span>
                </div>
                <p class="text-gray-600 mb-4">Dicari Manajer Hotel berpengalaman untuk mengelola resort mewah di
                    Sumba Barat. Pengalaman min. 3 tahun di industri hospitality.</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Dibuka 2 hari lalu</span>
                    <button class="bg-tribun-red text-white px-4 py-2 rounded hover:bg-red-700">
                        Lamar Sekarang
                    </button>
                </div>
            </div>

            <!-- Job 2 -->
            <div class="job-card bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-tribun-red mb-2">Guru SD</h3>
                        <p class="text-gray-600">SD Negeri 1 Waingapu</p>
                    </div>
                    <img src="https://placehold.co/60x60" alt="Logo SD Negeri 1 Waingapu"
                        class="w-12 h-12 object-cover rounded">
                </div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-sumba-green/10 text-sumba-green px-3 py-1 rounded-full text-sm">Waingapu</span>
                    <极端な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。 <span
                        class="bg-tribun-blue/10 text-tribun-blue px-3 py-1 rounded-full text-sm">Full-time</span>
                        <span class="bg-tribun-red/10 text-tribun-red px-3 py-1 rounded-full text-sm">Rp 4-6
                            Juta</span>
                </div>
                <p class="text-gray-600 mb-4">Dibutuhkan Guru SD untuk mata pelajaran umum. Pria/Wanita, S1
                    Pendidikan, bersedia ditempatkan di daerah pedesaan Sumba Timur.</p>
                <div class="flex justify-between items-center">
                    <span极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。 <span class="text-sm text-gray-500">Dibuka 1 minggu
                        lalu</span>
                        <button class="bg-tribun-red text-white px-4 py-2 rounded hover:bg-red-700">
                            Lamar Sekarang
                        </button>
                </div>
            </div>

            <!-- Job 3 -->
            <div class="job-card bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-tribun-red mb-2">Perawat</h3>
                        <p class="text-gray-600">Rumah Sakit Umum Sumba</p>
                    </div>
                    <img src="https://placehold.co/60x60" alt="Logo Rumah Sakit Umum Sumba"
                        class="w-12极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。
                        <img src="https://placehold.co/60x60"
                        alt="Logo Rumah Sakit Umum Sumba" class="w-12 h-12 object-cover rounded">
                </div>
                <div class="flex flex-wrap gap极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。
                    <div class="flex
                    flex-wrap gap-2 mb-4">
                    <span class="bg-sumba-green/10 text-sumba-green px-3 py-1 rounded-full text-sm">West
                        Sumba</span>
                    <span
                        class="bg-tribun-blue/极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。
                        <span class="bg-tribun-blue/10
                        text-tribun-blue px极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。 <span
                        class="bg-tribun-blue/10 text-tribun-blue px-3 py-1 rounded-full text-sm">Shift</span>
                    <span class="bg-tribun-red/10 text-tribun-red px-3 py-1 rounded-full text-sm">Rp 5-7
                        Juta</span>
                </div>
                <p class="text-gray-600 mb-4">Dibutuhkan Perawat profesional untuk rumah sakit umum. D3/S1
                    Keperawatan, memiliki STR aktif, pengalaman min. 2 tahun.</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Dibuka 3 hari lalu</span>
                    <button class="bg-tribun-red text-white px-4 py-2 rounded hover:bg-red-700">
                        Lamar Sekarang
                    </button>
                </div>
            </div>

            <!-- Job 4 -->
            <div class="job-card bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-tribun-red mb-2">Agricultural Specialist</h3>
                        <p class="text-gray-600">Sumba Agriculture Development</p>
                    </div>
                    <img src="https://placehold.co/60x60" alt="Logo Sumba Agriculture Development"
                        class="w-12 h-12 object-cover rounded">
                </div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-sumba-green/10 text-sumba-green px-3 py-1 rounded-full text-sm">East
                        Sumba</span>
                    <span
                        class="bg-tribun-blue/10 text-t极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。
                        <span class="bg-tribun-blue/10
                        text-tribun-blue px-3 py-1 rounded-full text-sm">Full-time</span>
                    <span
                        class="bg-tribun-red/10 text-tribun-red px-3 py-1 rounded-full text极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。
                        <span class="bg极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。
                        <span class="bg-tribun-red/10 text-tribun-red px-3 py-1 rounded-full text-sm">Rp 6-9
                        Juta</span>
                </div>
                <p class="text-gray-600 mb-4">Spesialis pertanian untuk mengembangkan teknik pertanian modern di
                    Sumba. S1 Pertanian, pengalaman di bidang agricultural development.</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Dibuka 5 hari lalu</极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。 <span
                            class="text-sm text-gray-500">Dibuka 5 hari lalu</span>
                    <button class="bg-tribun-red text-white px-4 py-2 rounded hover:bg-red-700">
                        Lamar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Training Programs -->
    <div class="bg-sumba-green text-white rounded-lg p-8 mb-12">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Program Pelatihan & Pengembangan</h2>
            <p class="text-xl mb-6">Tingkatkan skill dan kompetensi Anda dengan program pelatihan kami</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white/20 p-6 rounded-lg">
                    <i class="fas fa-laptop-code text-3xl mb-3"></i>
                    <h3 class="font-bold mb-2">Digital Marketing</h3>
                    <p>Pelatihan pemasaran digital untuk UMKM Sumba</p>
                </div>
                <div class="bg-white/20 p-6 rounded-lg">
                    <i class="fas fa-hands-helping text-3xl mb-3"></i>
                    <h3 class="font-bold mb-2">Hospitality Training</h3>
                    <p>Pelatihan service excellence untuk industri pariwisata</p>
                </div>
                <div class="bg-white/20 p-6 rounded-lg">
                    <i class="fas fa-seedling text-3xl mb-3"></i>
                    <h3 class极端的な簡潔さを避け、適切な詳細を提供するバランスの取れた応答を提供します。 <h3 class="font-bold mb-2">Agricultural Skills
                    </h3>
                    <p>Pelatihan teknik pertanian modern dan berkelanjutan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Stories -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-center mb-8">Kisah Sukses</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="https://placehold.co/100x100" alt="Maria - Guru di Sumba"
                    class="w-20 h-20 rounded-full mx-auto mb-4">
                <h3 class="font-bold text-lg mb-2">Maria</h3>
                <p class="text-tribun-red mb-2">Guru - SD Negeri Waikabubak</p>
                <p class="text-gray-600">"Program pengembangan guru memberikan saya skills baru untuk mengajar
                    dengan lebih efektif."</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="https://placehold.co/100x100" alt="Yohanes - Hotel Manager"
                    class="w-20 h-20 rounded-full mx-auto mb-4">
                <h3 class="font-bold text-lg mb-2">Yohanes</h3>
                <p class="text-tribun-red mb-2">Manajer Hotel - Nihi Sumba</p>
                <p class="text-gray-600">"Karir saya berkembang pesat sejak mengikuti program hospitality training
                    di Sumba."</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="https://placehold.co/100x100" alt="Siti - Agricultural Specialist"
                    class="w-20 h-20 rounded-full mx-auto mb-4">
                <h3 class="font-bold text-lg mb-2">Siti</h3>
                <p class="text-tribun-red mb-2">Spesialis Pertanian</p>
                <p class="text-gray-600">"Pelatihan pertanian modern membantu saya meningkatkan produktivitas
                    lahan."</p>
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        // Simple filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[type="text"]');
            const locationSelect = document.querySelector('select:nth-of-type(1)');
            const categorySelect = document.querySelector('select:nth-of-type(2)');

            function filterJobs() {
                const searchTerm = searchInput.value.toLowerCase();
                const locationValue = locationSelect.value;
                const categoryValue = categorySelect.value;

                document.querySelectorAll('.job-card').forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const location = card.querySelector('.bg-sumba-green').textContent.toLowerCase();
                    const category = card.querySelector('p.text-gray-600').textContent.toLowerCase();

                    const matchesSearch = title.includes(searchTerm) || searchTerm === '';
                    const matchesLocation = location.includes(locationValue) || locationValue === '';
                    const matchesCategory = category.includes(categoryValue) || categoryValue === '';

                    if (matchesSearch && matchesLocation && matchesCategory) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterJobs);
            locationSelect.addEventListener('change', filterJobs);
            categorySelect.addEventListener('change', filterJobs);

            // Smooth scrolling for category badges
            document.querySelectorAll('.category-badge').forEach(badge => {
                badge.addEventListener('click', function() {
                    const category = this.querySelector('h3').textContent.toLowerCase();
                    categorySelect.value = category;
                    filterJobs();
                    window.scrollTo({
                        top: document.querySelector('.mb-12').offsetTop - 100,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
@endsection
