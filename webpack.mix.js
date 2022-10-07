const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.vue()
    .css("node_modules/bootstrap-icons/font/bootstrap-icons.css", "public/css")

    .js('resources/js/app.js', 'public/js')

    .sass("resources/sass/auth/app.scss", "public/css/auth")

    .sass("resources/sass/panel/app.scss", "public/css/panel")
    .scripts(["node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"], "public/js/panel/bootstrap.js");
