module.exports = {
  purge: [
     './resources/views/**/*.blade.php',
     './vendor/lasallesoftware/ls-contactformfrontend-pkg/views/**/*.blade.php',
     '../../versiontwopointone/packages/ls-lasalleui-pkg/views/**/*.blade.php',
     ],
  theme: {
      extend: {
          colors: {
              'purple': {
                  100: '#ECE6E6',
                  200: '#D1C1C1',
                  300: '#B59B9C',
                  400: '#7D5052',
                  500: '#450508',
                  600: '#3E0507',
                  700: '#290305',
                  800: '#1F0204',
                  900: '#150202',
              },
          }
      }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui')({
        layout: 'sidebar',
      })
  ]
}
// https://javisperez.github.io/tailwindcolorshades/#/?purple=450508&tv=1
