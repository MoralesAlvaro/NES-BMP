const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
    ],

    theme: {
        extend: {
			fontFamily: {
				sans: ['Nunito', ...defaultTheme.fontFamily.sans],
				roboto: ['Roboto'],
				poppins: ['Poppins'],

			},
			colors: {
				brown: {
                    100: '#E6DDD8',
                    200: '#C2ADA0',
                    300: '#9D816F',
                    400: '#9D816F',
                    500: '#735A4B',
					600: '#6C3B2A',
					800: '#DB763B',
					700: '#542F22',
                    900: '#5B2300',
				},
                yellow: {
                    900: '#865800',
                    800: '#a06d00',
                    700: '#ba8300',
                    600: '#d59a00',
                    500: '#efb106',
                    400: '#fdc325',
                    300: '#ffd344',
                    200: '#ffe260',
                    100: '#fff079'
                },

				ligthBlue: {
					500: '#00AAA9'
				}
			},
			boxShadow: {
				card: '0 4px 6px -1px rgb(0 0 0 / 0.25), 0 2px 4px -2px rgb(0 0 0 / 0.25)'
			},
        },
    },

    plugins: [
		require('@tailwindcss/forms'),
		require('flowbite/plugin')
	],
};
