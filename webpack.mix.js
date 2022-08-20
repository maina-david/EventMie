const mix = require('laravel-mix');

require('laravel-mix-polyfill');

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

mix.js('resources/js/app.js', 'public/js/app.js')
    .js('resources/js/vendor/eventmie-pro/events_show/index.js', 'public/js/events_show_v1.8.js')
    // use vue 2
    .vue({ version: 2 })
    .webpackConfig({
        optimization: {
            providedExports: false,
            sideEffects: false,
            usedExports: false
        },
        //CUSTOM
        resolve: {
            fallback: {
                "crypto": false,
                "crypto-browserify": require.resolve('crypto-browserify'), //if you want to use this module also don't forget npm i crypto-browserify 
            } 
        }
        //CUSTOM
    })
    .override((config) => {
        delete config.watchOptions;
    });
