import fs from 'fs';
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
        host: 'localhost.test',
        port: 5173,
        https: {
            key: fs.readFileSync('/home/oath/ssl-localhost/localhost.test-key.pem'),
            cert: fs.readFileSync('/home/oath/ssl-localhost/localhost.test.pem'),
        },
        hmr: {
            host: 'localhost.test',
        },
    },
});

