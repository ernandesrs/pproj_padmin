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
    .css("node_modules/bootstrap-icons/font/bootstrap-icons.css", "public/assets/css")

    .js('resources/js/app.js', 'public/assets/js/inertia')

    .css("resources/css/auth/app.css", "public/assets/css/auth")

    .css("resources/css/panel/app.css", "public/assets/css/panel")
    .scripts(["node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"], "public/assets/js/bootstrap.js")

    .css("resources/css/front/app.css", "public/assets/css/front")
    ;
