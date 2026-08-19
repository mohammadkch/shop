import { defineConfig } from 'vite';
import { resolve } from 'node:path';

const projectRoot = resolve(import.meta.dirname, '..');

export default defineConfig({
    root: projectRoot,
    publicDir: false,
    build: {
        outDir: resolve(projectRoot, 'public/build'),
        emptyOutDir: true,
        manifest: true,
        minify: 'oxc',
        rollupOptions: {
            treeshake: false,
            input: {
                shop: resolve(projectRoot, 'public/assets/custom/shop.js'),
                home: resolve(projectRoot, 'public/assets/custom/home.js'),
                category: resolve(projectRoot, 'public/assets/custom/category.js'),
                product: resolve(projectRoot, 'public/assets/custom/product.js'),
                cart: resolve(projectRoot, 'public/assets/custom/cart.js'),
                checkout: resolve(projectRoot, 'public/assets/custom/checkout.js'),
            },
            output: {
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
            },
        },
    },
});
