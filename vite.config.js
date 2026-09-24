import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    ...transformAssetUrls,
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        quasar({
            sassVariables: fileURLToPath(
                new URL('./resources/css/quasar-variables.scss', import.meta.url),
            ),
        }),
    ],
});
