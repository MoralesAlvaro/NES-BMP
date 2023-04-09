const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            'cocoa': '#592202',
            'capucchino': '#D7C9BF',
            'light-coffee': '#A6836F',
            'coffee': '#7F5E4C',
            'dark-coffee': '#552f17'
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
