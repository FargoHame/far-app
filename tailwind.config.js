module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./storage/framework/views/*.php'"
  ],
  theme: {
    extend: {
      colors: {
        'far-green-dark': '#3EC7C9',
        'far-green-light': 'rgba(62, 199, 201, 0.3)',
        'far-orange-dark': '#FDC5A7',
        'far-orange-light': 'rgba(253, 197, 167, 0.5)'
      },
      width: {
        '180' : '180px',
        '200' : '200px',
        '240' : '240px',
        '320' : '320px',
        '640' : '640px',
        '800': '800px',
        '1024': '1024px',
        '1280': '1280px',
      },
      minWidth: {
          '100' : '100px',
          '200' : '200px',
          '640' : '640px',
          '960' : '960px',
          '1280': '1280px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
