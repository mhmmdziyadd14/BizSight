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
                orange: {
                    50: '#fef3f0',
                    100: '#fde8e0',
                    200: '#fac1ae',
                    300: '#f69a7c',
                    400: '#f3754e',
                    500: '#f05423', // Primary Brand Orange
                    600: '#c03a14', // Brand Orange Dark
                    700: '#b6330c',
                    800: '#902a0d',
                    900: '#77260e',
                    950: '#401004',
                },
                navy: {
                    700: '#1e3a5f',
                    800: '#1e293b',
                    900: '#0f172a',
                    950: '#0a0f1d', // New Navy 950
                },
            },
        },
    },

    plugins: [forms],
};
