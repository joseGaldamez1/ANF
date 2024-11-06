import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom/login.css', 
                'resources/css/custom/menu.css', 
                'resources/css/custom/tablas.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
