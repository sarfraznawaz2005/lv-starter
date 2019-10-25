const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// combine and add our common scripts - used across modules
// only site-wide needed files should be added here
mix.babel([
    'public/js/app.js',
    'public/modules/core/js/plugins/datatables/fnFilterOnReturn.js',
    'public/modules/core/js/core.js',
], 'public/js/app.js');

// combine and add our common css files - used across modules
// only site-wide needed files should be added here
mix.styles([
    'public/css/app.css',
    'public/modules/core/css/common.css',
], 'public/css/app.css');

mix.version();
