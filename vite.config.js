import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// ✅ Optional: aktifkan compression kalau kamu deploy di server sendiri
// import viteCompression from 'vite-plugin-compression';

export default defineConfig(({ command, mode }) => {
    const isProduction = mode === 'production';

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            // ✅ Uncomment ini kalau kamu mau file JS/CSS di-zip otomatis (.gz atau .br)
            // viteCompression({ algorithm: 'brotliCompress' }),
        ],
        build: {
            // ✅ Code splitting — pisahkan vendor (library besar)
            rollupOptions: {
                output: {
                    manualChunks: {
                        // misal kamu pakai Alpine, Axios, atau Chart.js
                        vendor: ['alpinejs', 'axios'],
                    },
                },
            },
            // ✅ Optimasi output
            minify: isProduction ? 'esbuild' : false, // pakai terserah Terser kalau butuh ekstrem
            sourcemap: !isProduction, // nonaktifkan sourcemap di production
            cssCodeSplit: true, // pisahkan CSS tiap komponen
            chunkSizeWarningLimit: 600, // biar warning nggak muncul kalau file besar sedikit
        },
        optimizeDeps: {
            include: ['alpinejs'], // preload library kecil untuk parsing cepat
        },
        // ✅ Recommended buat cache dan preload
        cacheDir: 'node_modules/.vite_cache',
    };
});
