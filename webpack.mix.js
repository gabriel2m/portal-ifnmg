const mix = require('laravel-mix');

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

mix.js('resources/js/main.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css', [
        require('tailwindcss')
    ])
    .css('resources/css/admin.css', 'public/css')
    .copy('resources/icomoon/fonts', 'public/fonts')
    .copy('resources/img', 'public/img')
    .version()