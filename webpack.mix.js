let mix = require('laravel-mix');

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
mix.options({
    extractVueStyles: true,
    processCssUrls: true,
    purifyCss: true,
});
mix.js('resources/assets/js/clients-login.js', 'public/js/clients')
   .sass('resources/assets/sass/app.scss', 'public/css');
