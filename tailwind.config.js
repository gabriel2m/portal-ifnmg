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
        'blue-gray': colors.blueGray,
      }
    }
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
