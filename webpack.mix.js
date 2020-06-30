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
mix.browserSync("http://127.0.0.1:8000/");
mix.babelConfig({
    plugins: ['@babel/plugin-syntax-dynamic-import'],
})
mix.react('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/img', 'public/img');
if (mix.inProduction()) {
    mix.version()
    mix.disableNotifications();
}