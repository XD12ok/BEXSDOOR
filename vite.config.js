import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: 'localhost.test',  // gunakan domain yang sama dengan APP_URL
        port: 5173,
        hmr: {
            host: 'localhost.test', // sama seperti domain kamu akses dari browser
        },
    },
});
