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

    .css("resources/css/auth/app.css", "public/css/auth")

    .css("resources/css/panel/app.css", "public/css/panel")
    .scripts(["node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"], "public/js/bootstrap.js")

    .css("resources/css/front/app.css", "public/css/front")
    ;
