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

mix
    .copy('resources/icomoon/fonts', 'public/fonts')
    .copy('resources/img', 'public/img')
    .version()

/*
 * Main
 */
mix
    .css('resources/css/main.css', 'public/css', [
        require('tailwindcss')
    ])
    .js('resources/js/main.js', 'public/js')

/*
 * Admin
 */
mix
    .css('resources/css/admin.css', 'public/css')
    .js('resources/js/admin.js', 'public/js')

/*
 * Datatables
 */
mix
    .combine([
        'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
        'node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css',
    ], 'public/css/datatables.css')
    .combine([
        'node_modules/datatables.net/js/jquery.dataTables.min.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
        'node_modules/datatables.net-buttons/js/dataTables.buttons.min.js',
        'node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js',
        'node_modules/jszip/dist/jszip.min.js',
        'node_modules/datatables.net-buttons/js/buttons.html5.min.js',
    ], 'public/js/datatables.js')
    .copy('resources/datatables', 'public/datatables')

/*
 * Inputmask
 */
mix
    .copy('node_modules/inputmask/dist/jquery.inputmask.min.js', 'public/inputmask')

/*
 * Select2
 */
mix
    .combine([
        'node_modules/select2/dist/css/select2.min.css',
        'node_modules/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css',
    ], 'public/select2/select2.full.min.css')
    .combine([
        'node_modules/select2/dist/js/select2.full.min.js',
        'node_modules/select2/dist/js/i18n/pt-BR.js',
    ], 'public/select2/select2.full.min.js')

/*
 * Repeater
 */
mix
    .copy('node_modules/jquery.repeater/jquery.repeater.min.js', 'public/repeater')
