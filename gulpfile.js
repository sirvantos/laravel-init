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

var paths = {
    'bootstrap': './node_modules/bootstrap-sass/assets/'
}



elixir(function(mix) {
    mix
        .sass('app.scss', 'public/css/', {includePaths: [paths.bootstrap + 'stylesheets/']})
        .styles(
            [
                'public/css/app.css',
                '/resources/assets/css/vendor/jquery.dynatable.css',
                '/resources/assets/css/vendor/typeahead.css',
            ],
            'public/css/app.css'
            ,'./'
        )
        .browserify(['main.js'])
        .scripts([
            './resources/assets/js/vendor/jquery-1.7.2.min.js',
            './resources/assets/js/vendor/typehead.jquery.min.js',
            './resources/assets/js/vendor/jquery.dynatable.js',
            './public/js/bundle.js'
        ], 'public/js/all.js')
        .version(['public/css/app.css', 'public/js/all.js']);
});
