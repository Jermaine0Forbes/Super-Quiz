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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/style.scss', 'public/css');
// mix.scripts(['resources/js/functions.js','resources/js/chartjs-plugin-datalabels.min.js','resources/js/charts.js', 'resources/js/ajax.js'],
//  'public/js/root.js')
mix.scripts(['resources/js/functions.js',
             'resources/js/charts.js',
             'resources/js/ajax.js',
            ],'public/js/root.js')
    .sass('resources/sass/style.scss', 'public/css');
