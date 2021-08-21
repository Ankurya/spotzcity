var elixir = require('laravel-elixir');
require('laravel-elixir-bower');
require('laravel-elixir-webpack-official');
require('laravel-elixir-webpack-react');

Elixir.webpack.mergeConfig({
  babel: {
    presets: ['es2015', 'react']
  },
});

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
    .bower('vendor.css', 'public/assets/css', 'vendor.js', 'public/assets/js')
    .sass([''], 'public/assets/css/app.css')
    .webpack('app.jsx', 'public/assets/js/app.js')
    .version(['public/assets/css/app.css', 'public/assets/js/app.js', 'public/assets/js/vendor.js', 'public/assets/css/vendor.css']);
});
