import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/toast.css',
                'resources/css/home.css',
                'resources/css/header.css',
                'resources/css/about.css',
                'resources/css/add_admin.css',
                'resources/css/add_gallery.css',
                'resources/css/add_menu.css',
                'resources/css/add_menu_modal.css',
                'resources/css/admin_nav.css',
                'resources/css/auth.css',
                'resources/css/cart.css',
                'resources/css/contact.css',
                'resources/css/dashboard.css',
                'resources/css/form.css',
                'resources/css/order.css',
                'resources/css/payments.css',
                'resources/css/profile.css',
                'resources/css/reorder.css',
                'resources/css/reservation.css',
                'resources/css/track.css',
                'resources/css/view_reservations.css',

                'resources/js/app.js',
                'resources/js/header.js',
                'resources/js/toast.js',
                'resources/js/pwa.js',
                'resources/js/add_admin.js',
                'resources/js/add_gallery.js',
                'resources/js/add_menu.js',
                'resources/js/admin_nav.js',
                'resources/js/cart.js',
                'resources/js/form.js',
                'resources/js/home.js',
                'resources/js/order.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
