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

var plugin   = 'resources/js/plugins/';
var src_path = 'resources/js/';

mix.webpackConfig({
    resolve: {
        alias: {
            '@src': path.resolve(__dirname, src_path),
            '@store': path.resolve(__dirname, src_path + 'store'),
            '@layouts': path.resolve(__dirname, src_path + 'layouts'),
            '@views': path.resolve(__dirname, src_path + 'views'),
            '@components': path.resolve(__dirname, src_path + 'components'),
            '@common': path.resolve(__dirname, src_path + 'common'),
            '@public': path.resolve(__dirname, '/public'),
            '@store': path.resolve(__dirname, src_path + 'store/modules')
        }
    }
});

mix.js('resources/js/app.js', 'public/js')
    .combine([
       'public/js/app.js',
        plugin + 'jquery/jquery.min.js',
        plugin + 'momentjs/moment.min.js',
        plugin + 'popper/popper.min.js',
        plugin + 'responsejs/response.min.js',
        plugin + 'loading-overlay/loadingoverlay.min.js',
        plugin + 'loader/loader.min.js',
        plugin + 'tether/js/tether.min.js',
        plugin + 'jscrollpane/jquery.jscrollpane.min.js',
        plugin + 'jscrollpane/jquery.mousewheel.js',
        plugin + 'flexibility/flexibility.js',
        plugin + 'noty/noty.min.js',
        plugin + 'velocity/velocity.min.js',
        plugin + 'd3/d3.min.js',
        plugin + 'c3js/c3.min.js',
        plugin + 'maplace/maplace.min.js',
        plugin + 'select2/js/select2.min.js',
        plugin + 'flatpickr/flatpickr.min.js',
        plugin + 'jquery-confirm/jquery-confirm.min.js',
        plugin + 'bootstrap-touchspin/jquery.bootstrap-touchspin.min.js',
        'resources/js/custom.js',
    ], 'public/js/bundle.min.js')
   .sass('resources/sass/app.scss', 'public/css')
    .combine([

        plugin + 'bootstrap/css/bootstrap.min.css', //verified include @bundle.min.css

        plugin + 'tether/css/tether.min.css',
        plugin + 'jscrollpane/jquery.jscrollpane.css',
        plugin + 'flag-icon-css/css/flag-icon.min.css',
        plugin + 'c3js/c3.min.css',
        plugin + 'noty/noty.css',
        plugin + 'datatables-net/media/css/dataTables.bootstrap4.min.css',
        plugin + 'select2/css/select2.min.css',
        plugin + 'jquery-confirm/jquery.confirm.min.css',

        'fonts/line-awesome/css/line-awesome.min.css', //verified include
        'fonts/montserrat/styles.css', //verified include

        'node_modules/nprogress/nprogress.css',
        'public/css/app.css'
    ], 'public/css/bundle.min.css');
