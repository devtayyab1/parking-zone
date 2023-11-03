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
/*
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css'); */

   
   mix.styles([
    'assets/front/parkingzone/css/style.min.css',
    'assets/front/parkingzone/css/icons.css',
    'assets/front/parkingzone/css/styles.css',
    'assets/front/parkingzone/css/responsive.css',
    'assets/front/parkingzone/css/css1/styles.css',
    'assets/front/parkingzone/css/jquery-ui.min.css',
    'assets/front/parkingzone/css/settings.css',
    'assets/front/parkingzone/css/trx_addons_icons-embedded.css',
    'assets/front/parkingzone/css/trx_addons.css',
    'assets/front/parkingzone/css/trx_addons.animation.css',
    'assets/front/parkingzone/css/trx_addons.css',
    'assets/front/parkingzone/css/js_composer.min.css',
    'assets/front/parkingzone/css/jquery-ui-1.10.3.custom.css',
    'assets/front/parkingzone/css/booki.min.css',
    'assets/front/parkingzone/css/front.css',
    'assets/front/parkingzone/css/fontello-embedded.css',
    'assets/front/parkingzone/css/style.css',
    'assets/front/parkingzone/css/__custom.css',
    'assets/front/parkingzone/css/__colors_default.css',
    'assets/front/parkingzone/css/__colors_dark.css',
    'assets/front/parkingzone/css/trx_addons.responsive.css',
    'assets/front/parkingzone/css/responsive.css',
    'assets/front/parkingzone/css/icons.css'
], 'public/css/all.css');