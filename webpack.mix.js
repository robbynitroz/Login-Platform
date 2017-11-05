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
mix.js('resources/assets/js/platform-login.js', 'public/js/login')
   .sass('resources/assets/sass/login.scss', 'public/css')
   .sass('resources/assets/sass/client.scss', 'public/css');
