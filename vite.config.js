import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',  // Escucha en todas las interfaces de red, incluyendo localhost
        /* hmr: {
            host: 'localhost',  // Permite HMR en localhost, pero puedes cambiarlo a '0.0.0.0' si es necesario
        }, */
    }
});
