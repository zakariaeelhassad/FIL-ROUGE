import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
    define: {
        'process.env': {
            VITE_PUSHER_APP_KEY: process.env.VITE_PUSHER_APP_KEY,
            VITE_PUSHER_APP_CLUSTER: process.env.VITE_PUSHER_APP_CLUSTER,
        },
    },
});
