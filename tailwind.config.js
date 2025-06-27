const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#4B9C8C',
          50: '#EBF6F3',
          100: '#C7E5DE',
          200: '#A3D4C9',
          300: '#7FC3B4',
          400: '#5BB19F',
          500: '#4B9C8C',
          600: '#3D7E71',
          700: '#2F6156',
          800: '#20433C',
          900: '#122521',
        },
        secondary: {
          DEFAULT: '#F4A259',
          50: '#FEF4EB',
          100: '#FCDEC6',
          200: '#FAC7A1',
          300: '#F8B17B',
          400: '#F4A259',
          500: '#F08928',
          600: '#D36F10',
          700: '#A2550C',
          800: '#713B08',
          900: '#412104',
        },
        accent: {
          DEFAULT: '#5B8CDE',
          50: '#EEF3FB',
          100: '#D0E0F6',
          200: '#B2CCF0',
          300: '#93B9EA',
          400: '#75A5E4',
          500: '#5B8CDE',
          600: '#3170D5',
          700: '#255BB8',
          800: '#1D478F',
          900: '#143266',
        },
        neutral: {
          DEFAULT: '#433A37',
          50: '#EAE7E6',
          100: '#D4CFCD',
          200: '#BEB7B5',
          300: '#A99F9C',
          400: '#938783',
          500: '#776D6B',
          600: '#625956',
          700: '#4D4643',
          800: '#433A37',
          900: '#231E1C',
        },
        // Several additional brand colors
        gray: {
          DEFAULT: '#F8F8F7',
          100: '#FFFFFF',
          200: '#FCFCFC',
          300: '#FAFAFA',
          400: '#F8F8F7',
          500: '#E0E0DF',
          600: '#C9C9C8',
          700: '#A3A3A2',
          800: '#7E7E7D',
          900: '#585857',
        },
      },
      fontFamily: {
        sans: ['Open Sans', 'sans-serif'],
      },
      boxShadow: {
        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
        'header': '0 2px 4px rgba(0, 0, 0, 0.1)',
      },
      container: {
        center: true,
        padding: {
          DEFAULT: '1rem',
          sm: '2rem',
          lg: '3rem',
          xl: '4rem',
        },
      },
    },
  },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/aspect-ratio'), require('tailwindcss-animate')],
};
