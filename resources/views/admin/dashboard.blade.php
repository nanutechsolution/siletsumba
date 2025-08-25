<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Halo Admin! Selamat datang di panel administrasi Silet Sumba.') }}
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Total Artikel</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">1,247</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Total Views</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">2.8M</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Komentar</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">14,582</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Penulis Aktif</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">28</p>
                </div>
            </div>

            <!-- Recent Articles -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Artikel Terbaru</h3>
                <ul class="space-y-4">
                    <li class="flex justify-between border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">Presiden Resmikan Proyek Infrastruktur
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">2 jam yang lalu</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Published</span>
                    </li>
                    <li class="flex justify-between border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">Timnas Indonesia Juara Turnamen</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">5 jam yang lalu</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Draft</span>
                    </li>
                    <li class="flex justify-between border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">Pertemuan Koalisi Partai Politik</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">7 jam yang lalu</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Published</span>
                    </li>
                </ul>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Aktivitas Terbaru</h3>
                <ul class="space-y-4">
                    <li class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-white">Admin menambahkan penulis baru</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">30 menit yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-white">Artikel disetujui untuk publikasi</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">1 jam yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-times text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-white">Komentar spam dihapus</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">2 jam yang lalu</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
