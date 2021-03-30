const mix = require('laravel-mix');
const path = require('path');

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

mix.js('resources/js/app.js', 'public/js')
    .vue({
        version: 2,
        extractStyles: true,
        globalStyles: false
    })
    .js('resources/js/admin/admin.js', 'public/js')
    .js('resources/js/admin/roles.js', 'public/js')
    .js('resources/js/admin/categories.js', 'public/js')
    .js('resources/js/admin/products.js', 'public/js')
    .js('resources/js/admin/productsCr.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin/multiselect.scss', 'public/css')
    .sass('resources/sass/admin/roles.scss', 'public/css')
    .sass('resources/sass/admin/vgt.scss', 'public/css')
    .sass('resources/sass/admin/form.scss', 'public/css')
    .sass('resources/sass/admin/gallery.scss', 'public/css')
    .sourceMaps();

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/'),
            '@adminpages': path.resolve(__dirname, 'resources/js/admin/components/'),
            '@admin': path.resolve(__dirname, 'resources/js/admin/'),
        }
    }
});