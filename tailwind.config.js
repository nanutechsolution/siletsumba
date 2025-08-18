import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'silet-primary': 'var(--color-silet-primary)',
                'silet-secondary': 'var(--color-silet-secondary)',
                'silet-menu-bg': 'var(--color-silet-menu-bg)',
            },
        },
    },
    plugins: [forms],
};
