var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
//var elixir = require('laravel-elixir');

//require('./elixir-extensions');
//require('./elixir-extensions');
var paths = {
    'bootstrap': './node_modules/bootstrap/'
}

elixir(function(mix) {
    //mix.sass('app.scss');
    mix.sass([
            'app.scss',
        ], 'public/css')
        //.browserify('app.js')
        .scripts([
            //paths.jquery + "dist/jquery.js",
            paths.bootstrap + "dist/js/bootstrap.js"
        ], './public/js/', 'public/js/app.js');

});
 