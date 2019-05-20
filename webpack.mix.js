const mix = require("laravel-mix");

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

mix.version()
    .extract() // JSで3ソース出力、キャッシュの有効活用ができる
    .sourceMaps() // 開発用のソースマップ
    .js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "../resources/assets/build/css/")
    .sass("resources/sass/base.scss", "../resources/assets/build/css/")
    // buildディレクトリに出力したcssファイルを、
    // app.cssというファイルに１つにまとめてpublicディレクトリへ出力する
    .styles(
        [
            "resources/assets/build/css/app.css",
            "resources/assets/build/css/base.css"
        ],
        "public/css/app.css"
    );
