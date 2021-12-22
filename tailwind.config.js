const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    container: {
      center: true,
    },
    extend: {
      textColor: {
        'violet': colors.violet,
      },
      colors: {
        'blue-gray': colors.blueGray,
        'ifnmg-green': {
          1: '#17882c',
          2: '#00420c',
          3: '#002907',
        }
      }
    }
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
