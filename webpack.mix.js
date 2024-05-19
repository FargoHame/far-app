const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [require("postcss-import"), require("tailwindcss"), require("autoprefixer")]
);
mix.sass("resources/scss/main.scss", "public/css");
mix.copy(
    "node_modules/lightbox2/dist/css/lightbox.min.css",
    "public/css/lightbox.min.css"
);
mix.copy(
    "node_modules/@splidejs/splide/dist/css/splide.min.css",
    "public/css/splide.min.css"
);
mix.copy(
    "node_modules/lightbox2/dist/js/lightbox-plus-jquery.min.js",
    "public/js/lightbox-plus-jquery.min.js"
);
mix.copy(
    "node_modules/@splidejs/splide/dist/js/splide.min.js",
    "public/js/splide.min.js"
);
