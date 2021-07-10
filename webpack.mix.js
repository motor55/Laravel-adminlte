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

// mix.js('resources/js/app.js', 'public/backend/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/backend/css');


mix
    .setPublicPath('public')
    // .setResourceRoot('../')

    // Backend
    .js('resources/js/backend/app.js', 'js/backend/app.js')
    .sass('resources/sass/backend/app.scss', 'css/backend/app.css')
    .vue()


    // Frontend
    .js('resources/js/frontend/app.js', 'js/frontend/app.js')
    .sass('resources/sass/frontend/app.scss', 'css/frontend/app.css');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.webpackConfig({
        devtool: 'inline-source-map'
    });
}
