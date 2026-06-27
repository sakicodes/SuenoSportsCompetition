import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Listen on all network interfaces
        hmr: {
            host: 'localhost' // Tell the browser to connect to localhost
        },
        watch: {
            usePolling: true, // Crucial for Docker on Linux/WSL
        }
    }
});
