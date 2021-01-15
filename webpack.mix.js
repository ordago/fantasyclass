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
// mix.config.webpackConfig.output = {
//     chunkFilename: 'scripts/[name].[chunkhash].js',
//     publicPath: '/',
// };

// mix.webpackConfig({
//     output: {
//         chunkFilename: '[name].js?id=[chunkhash]',
//     }
// });

mix.js([
        'resources/js/app.js',
    ], 'public/js')
    .version()

mix.sass('resources/sass/app.scss', 'public/css').options({
        processCssUrls: mix.inProduction()
    })
    .version();

if (mix.inProduction()) {
    // mix.minify('public/js/index.js');
    mix.version();
}



require('laravel-mix-bundle-analyzer');

if (mix.isWatching()) {
    mix.bundleAnalyzer();
}

mix.webpackConfig({
    output: {
        chunkFilename: 'js/vuejs_code_split/[name].[chunkhash].js',
    }
});
