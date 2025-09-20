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
                'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            fontSize: {
                'fluid-h1': 'clamp(1.5rem, 5vw, 3rem)',
            },
            colors: {
                silet: {
                    red: '#E41E2D',
                    dark: '#1a1a1a',
                    gray: '#f5f5f5'
                },
                sumba: {
                    green: '#16a34a',
                    gold: '#d97706',
                    brown: '#78350f'
                },
                primary: {
                    50: '#faf5ff',
                    100: '#f3e8ff',
                    200: '#e9d5ff',
                    300: '#d8b4fe',
                    400: '#c084fc',
                    500: '#a855f7',
                    600: '#9333ea',
                    700: '#7c3aed',
                    800: '#6b21a8',
                    900: '#581c87',
                    red: '#E21B1B',
                    dark: '#1A1A1A',
                    blue: '#1E40AF'
                },
                'silet-primary': 'var(--color-silet-primary)',
                'silet-secondary': 'var(--color-silet-secondary)',
                'silet-menu-bg': 'var(--color-silet-menu-bg)',
            },
        },
    },
    plugins: [forms, require('@tailwindcss/typography'),
    ],
};
