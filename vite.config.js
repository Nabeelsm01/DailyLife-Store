import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/product-slider.css',  // ⭐ เพิ่มบรรทัดนี้
            ],
            refresh: true,
        }),
    ],
    // ⭐ เพิ่มส่วนนี้สำหรับ Production
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    // ⭐ สำหรับ HTTPS/Production
    server: {
        https: false,
        host: true,
    },
});
