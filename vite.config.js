import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'

export default defineConfig({
    server: {
        host: '127.0.0.1'
    },
    plugins: [
        laravel({
            input: [
                'resources/front/css/style.scss',
                'resources/js/app.js',
                'resources/front/js/app.js',
                'resources/js/front/apps.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve('./resources'),
        }
    },
});
