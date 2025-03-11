import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/sass/client.scss',
                'resources/js/client.js',
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
            vue: 'vue/dist/vue.esm-bundler.js',
            $resImage: resolve('./resources/images')
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler' // or "modern"
            }
        }
    },
    build: {
        chunkSizeWarningLimit: 500, // adjust this value to your needs
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes('node_modules/tns')|| id.includes('node_modules/axios') || id.includes('node_modules/bootstrap')) {
                        return 'vendor-tns-axios';
                    } else if (id.includes('node_modules/@vue')  || id.includes('node_modules/vue') || id.includes('node_modules/vuex') || id.includes('node_modules/vue-toast-notification') ) {
                        return 'vendor-vue';
                    } else if (id.includes('node_modules/chart.js')) {
                        return 'vendor-chart';
                    } else if (id.includes('node_modules/three')) {
                        return 'vendor-three';
                    } else if (id.includes('node_modules')) {
                        return 'vendor-others';
                    }
                    return 'app';
                },

            },
        },
    },
});
