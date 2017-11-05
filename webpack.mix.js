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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['vue'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .version()
    .webpackConfig({
        // 自定义webpack的配置
    });

if (!mix.inProduction) {
    // 生成资源映射
    mix.sourceMaps();
}

// 禁用系统通知
mix.disableNotifications();

