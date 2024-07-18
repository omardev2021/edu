import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],

            },
            colors: {
                softBlue: '#4115BA',
                lightBlue: '#541BF1',
                softRed: '#00E6A7',
                purpleCustom:'#6E41F5',
                customGray: 'hsl(229, 8%, 60%)',
                veryDarkBlue: '#150a42',
                mainColor: '#F3F4FF',
                grayDark:'#999999',
                darkBlue:'#220081'
            },
        },
        fontFamily:{
            "primary":["Cairo","sans-serif"],
            "secondary":["Lemonada","sans-serif"],
            "arabic":["El Messiri","sans-serif"],
        }
    },

    plugins: [forms, typography],
};
