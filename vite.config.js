import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { local } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                // Self-hosted Inter (latin subset, WOFF2 only) from resources/fonts — no
                // third-party font requests at runtime and no redundant WOFF fallbacks.
                // Only the two most-used weights are preloaded to protect LCP.
                local('Inter', {
                    variants: [
                        { src: 'resources/fonts/inter/inter-400-normal.woff2', weight: 400 },
                        { src: 'resources/fonts/inter/inter-500-normal.woff2', weight: 500 },
                        { src: 'resources/fonts/inter/inter-600-normal.woff2', weight: 600 },
                        { src: 'resources/fonts/inter/inter-700-normal.woff2', weight: 700 },
                    ],
                    preload: [{ weight: 400 }, { weight: 600 }],
                    display: 'swap',
                    // Metric-matched fallbacks need the optional "fontaine" package.
                    // Install it (npm i -D fontaine) and set this to true to reduce CLS further.
                    optimizedFallbacks: false,
                    fallbacks: ['ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'Arial', 'sans-serif'],
                }),
            ],
        }),
        tailwindcss(),
    ],
    build: {
        cssCodeSplit: true,
        sourcemap: false,
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
