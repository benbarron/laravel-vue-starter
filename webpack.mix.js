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

mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        loader: 'ts-loader',
        exclude: /node_modules/,
        options: {
          appendTsSuffixTo: [/\.vue$/]
        }
      }
    ]
  },
  resolve: {
    extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx']
  }
});

mix
  .js('resources/js/index.ts', 'public/js/app.js')
  .sass('resources/sass/admin/main.scss', 'public/css/admin.css')
  .sass('resources/sass/auth/main.scss', 'public/css/auth.css')
  .sass('resources/sass/site/main.scss', 'public/css/site.css');
