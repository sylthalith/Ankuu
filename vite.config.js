import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/index.css',
                'resources/js/index.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Доступ извне контейнера
        port: 5173,
        hmr: {
            host: 'localhost', // Или 0.0.0.0 для доступа с хоста
        },
    },
});
