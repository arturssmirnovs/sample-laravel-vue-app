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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/assets/img', 'public/assets/img')
    .copyDirectory('resources/assets/flags', 'public/assets/flags')
    .copyDirectory('resources/assets/svg', 'public/assets/svg')
    .sourceMaps()
    .vue()
    .webpackConfig((webpack) => {
        return {
            plugins: [
                new webpack.DefinePlugin({
                    __VUE_OPTIONS_API__: true,
                    __VUE_PROD_DEVTOOLS__: false,
                }),
            ],
            resolve: {
                 alias: {
                     '@': __dirname + '/resources'
                 }
            }
        };
    })

if (mix.inProduction()) {
    mix.version()
}
