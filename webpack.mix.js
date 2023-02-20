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
    .js('resources/js/main.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css', [
        require('tailwindcss')
    ])

/*
 * Admin
 */
mix
    .js('resources/js/admin.js', 'public/js')
    .css('resources/css/admin.css', 'public/css')

/*
* Datatables
*/
mix
    .combine([
        'node_modules/datatables.net/js/jquery.dataTables.min.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
        'node_modules/datatables.net-responsive/js/dataTables.responsive.min.js',
        'node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
    ], 'public/js/datatables.js')
    .css('resources/css/datatables.css', 'public/css')
    .copy('resources/datatables', 'public/datatables')