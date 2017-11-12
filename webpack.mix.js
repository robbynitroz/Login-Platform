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
    extractVueStyles: 'public/css/styles.css',
    processCssUrls: true,
    //uglify: {},
    purifyCss: true,
//purifyCss: {},
    postCss: [require('autoprefixer')],
    clearConsole: false
});

mix.webpackConfig({
    output: {
        publicPath: '/',
        chunkFilename: 'js/[name].[chunkhash].js',
    },
});

mix.js('resources/assets/js/clients-login.js', 'public/js/clients')
    .sass('resources/assets/sass/client.scss', 'public/css/client');
mix.js('resources/assets/js/auth.js', 'public/js/login')
   .sass('resources/assets/sass/auth.scss', 'public/css/login')

