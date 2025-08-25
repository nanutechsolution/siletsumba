@extends('welcome')
@section('content')
    <section class="bg-gradient-to-r from-tribun-red to-red-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Bergabung dengan Tim TRIBUN NEWS</h1>
            <p class="text-xl max-w-3xl mx-auto mb-8">
                Jadilah bagian dari media berita terdepan dan berkontribusi dalam menyebarkan informasi yang akurat dan
                bermanfaat
            </p>
            <a href="#lowongan"
                class="bg-white text-tribun-red px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                Lihat Lowongan
            </a>
        </div>
    </section>
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Why Join Us -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-12">Mengapa Bergabung dengan Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Tim Profesional</h3>
                    <p class="text-gray-600">Bekerja dengan para profesional media yang berpengalaman dan berdedikasi
                        tinggi</p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Pengembangan Karir</h3>
                    <p class="text-gray-600">Kesempatan pengembangan karir dan pelatihan yang berkelanjutan</p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-newspaper text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Dampak Nyata</h3>
                    <p class="text-gray-600">Berkontribusi pada masyarakat melalui penyebaran informasi yang bermanfaat
                    </p>
                </div>
            </div>
        </section>

        <!-- Job Openings -->
        <section id="lowongan" class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-8">Lowongan Pekerjaan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job 1 -->
                <div class="job-card bg-white rounded-lg shadow-md p-6">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full mb-4 inline-block">
                        Full-time
                    </span>
                    <h3 class="text-xl font-bold text-tribun-red mb-2">Jurnalis</h3>
                    <p class="text-gray-600 mb-4">Mencari berita, melakukan investigasi, dan menulis artikel berkualitas
                        untuk berbagai platform media</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">S1 Jurnalistik</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">2+ Tahun
                            Pengalaman</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">Jakarta</span>
                    </div>
                    <button class="bg-tribun-red text-white px-6 py-2 rounded hover:bg-red-700 transition-colors">
                        Lamar Sekarang
                    </button>
                </div>

                <!-- Job 2 -->
                <div class="job-card bg-white rounded-lg shadow-md p-6">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full mb-4 inline-block">
                        Part-time
                    </span>
                    <h3 class="text-xl font-bold text-tribun-red mb-2">Kontributor Wilayah</h3>
                    <p class="text-gray-600 mb-4">Meliput berita lokal di daerah, memberikan laporan langsung dari
                        lapangan</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">SMA/D3</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">1+ Tahun
                            Pengalaman</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">Sumba</span>
                    </div>
                    <button class="bg-tribun-red text-white px-6 py-2 rounded hover:bg-red-700 transition-colors">
                        Lamar Sekarang
                    </button>
                </div>

                <!-- Job 3 -->
                <div class="job-card bg-white rounded-lg shadow-md p-6">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full mb-4 inline-block">
                        Full-time
                    </span>
                    <h极 class="text-xl font-bold text-tribun-red mb-2">Editor Berita</h3>
                        <p class="text-gray-600 mb-4">Mengedit dan menyunting naskah berita, memastikan kualitas dan
                            akurasi konten</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">S1
                                Bahasa/Sastra</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">3+ Tahun
                                Pengalaman</span>
                            <span class="bg-gray-100 text-gray-700 px-3py-1 rounded-full text-sm">Jakarta</span>
                        </div>
                        <button class="bg-tribun-red text-white px-6 py-2 rounded hover:bg-red-700 transition-colors">
                            Lamar Sekarang
                        </button>
                </div>

                <!-- Job 4 -->
                <div class="job-card bg-white rounded-lg shadow-md p-6">
                    <span
                        class="bg-purple-100 text-purple-800 text-xs font-medium px-3 py-1 rounded-full mb-4 inline-block">
                        Internship
                    </span>
                    <h3 class="text-xl font-bold text-tribun-red mb-2">Magang Jurnalistik</h3>
                    <p class="text-gray-600 mb-4">Program magang untuk mahasiswa yang ingin belajar praktik jurnalistik
                        langsung</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">Mahasiswa Aktif</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">Min. Semester 5</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">Jakarta/Sumba</span>
                    </div>
                    <button class="bg-tribun-red text-white px-6 py-2 rounded hover:bg-red-700 transition-colors">
                        Lamar Sekarang
                    </button>
                </div>
            </div>

            <!-- Karir di Sumba Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8 mt-12">
                <h3 class="text-2xl font-bold text-center mb-6 text-blue-800">
                    <i class="fas fa-map-marker-alt mr-2"></i>Kesempatan Karir di Sumba
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold text-lg mb-3">Posisi yang Tersedia:</h4>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Kontributor Berita Lokal Sumba
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Fotografer Wilayah Sumba
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Jurnalis Wisata Sumba
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Staf Administrasi Regional
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-lg mb-3">Keuntungan Bekerja di Sumba:</h4>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-center">
                                <i class="fas fa-home text-blue-500 mr-2"></i>
                                Dekat dengan tempat tinggal
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-tree text-green-500 mr-2"></i>
                                Lingkungan kerja yang asri
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-users text-purple-500 mr-2"></i>
                                Komunitas lokal yang mendukung
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-gem text-yellow-500 mr-2"></i>
                                Peluang mengembangkan potensi daerah
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-6">
                    <a href="mailto:karir.sumba@tribunnews.com"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Kirim Lamaran untuk Sumba
                    </a>
                </div>
            </div>
        </section>
        <!-- Application Process -->
        <section class="bg-white rounded-lg shadow-md p-8 mb-16">
            <h2 class="text-3xl font-bold text-center mb-8">Proses Lamaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">1</span>
                    </div>
                    <h3 class="font-semibold mb-2">Kirim CV</h3>
                    <p class="text-sm text-gray-600">Kirim CV dan portofolio ke email kami</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">2</span>
                    </div>
                    <h3 class="font-semib极 mb-2">Seleksi Administrasi</h3>
                    <p class="text-sm text-gray-600">Tim HR akan meninjau dokumen Anda</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Wawancara</h3>
                    <p class="text-sm text-gray-600">Proses wawancara dengan tim terkait</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-tribun-red rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">4</span>
                    </div>
                    <h3 class="font-semibold mb-2">Bergabung</h3>
                    <p class="text-sm text-gray-600">Selamat bergabung dengan tim!</p>
                </div>
            </div>
        </section>
        <!-- Contact Info -->
        <section class="text-center">
            <h2 class="text-3xl font-bold mb-4">Tertarik Bergabung?</h2>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Kirim lamaran Anda dan jadilah bagian dari tim profesional kami yang berdedikasi menyebarkan informasi
                berkualitas
            </p>
            <div class="bg-gray-100 rounded-lg p-6 max-w-md mx-auto">
                <h3 class="font-semibold mb-4">Informasi Kontak Karir:</h3>
                <p class="mb-2">
                    <i class="fas fa-envelope text-tribun-red mr-2"></i>
                    karir@tribunnews.com
                </p>
                <p class="mb-2">
                    <i class="fas fa-phone text-tribun-red mr-2"></i>
                    (021) 1234-5678
                </p>
                <p>
                    <i class="fas fa-clock text-tribun-red mr-2"></i>
                    Senin - Jumat, 09:00 - 17:00
                </p>
            </div>
        </section>
        <script>
            // Smooth scrolling untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Animasi untuk job cards
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.job-card').forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        </script>
    @endsection
