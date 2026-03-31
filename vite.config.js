/**
 * Vite entry points (resources/css/app.css, resources/js/app.js) build Tailwind + app.js.
 * The public site layout loads CSS/JS via asset('css/style.css') and public/js/*.js instead
 * of @vite — keep this until a deliberate migration wires @vite into Blade without breaking
 * Bootstrap/MDB styling (Tailwind preflight would conflict unless scoped).
 */
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
});
