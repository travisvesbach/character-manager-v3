const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: {
                    light: '#c0fad0',
                    DEFAULT: '#70c989',
                },
                gray: {
                    lighter: '#3c4c55',
                    light: '#2A3840',
                    DEFAULT: '#253036',
                    dark: '#1f282d',
                    darker: '#171717'
                }
            }
        }
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
