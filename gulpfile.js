
const elixir = require('laravel-elixir');

elixir(mix => {

    // Configure webpack
    // @see: https://github.com/JeffreyWay/laravel-elixir-webpack-official
    // @see: http://stackoverflow.com/questions/29548386/how-should-i-use-moment-timezone-with-webpack

    Elixir.webpack.mergeConfig({
        module: {
            loaders: {
                include: /\.json$/,
                loaders: ['json-loader']
            }
        },
        resolve: {
            extensions: ['', '.json', '.jsx', '.js']
        }
    });

    // copy vendor javascripts

    mix.copy([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/skel-framework/dist/skel.min.js',
        'node_modules/moment/min/moment-with-locales.min.js',
        'node_modules/moment-timezone/builds/moment-timezone-with-data-2010-2020.min.js',
    ], 'resources/assets/js/vendor');

    // publish crap for IE

    mix.copy('resources/assets/js/ie', 'public/assets/js/ie');
    mix.sass('ie8.scss', 'public/assets/css/ie8.css');
    mix.sass('ie9.scss', 'public/assets/css/ie9.css');

    // publish fonts

    mix.copy('resources/assets/fonts', 'public/assets/fonts');

    // combine vendor javascripts
    
    mix.combine([
        'resources/assets/js/vendor/skel.min.js',
        'resources/assets/js/vendor/jquery.min.js',
        'resources/assets/js/vendor/jquery.scrollex.min.js',
        'resources/assets/js/vendor/moment-with-locales.min.js',
        'resources/assets/js/vendor/moment-timezone-with-data-2010-2020.min.js',
    ], 'public/assets/js/vendor.js')

    // pack custom javascripts

    mix.webpack('app.js', 'public/assets/js/app.js');

    // process scss

    mix.sass('main.scss', 'public/assets/css/app.css');

    mix.copy('resources/assets/images', 'public/assets/css/images');    

});
