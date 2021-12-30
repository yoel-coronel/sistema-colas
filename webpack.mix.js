const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
mix.styles([
    'resources/ui/css/ycoronel.fontwesome.min.css',
  //  'resources/ui/css/ycoronel.bootstrap-4.min.css',
    'resources/ui/css/ycoronel.icheck-bootstrap.min.css',
    'resources/ui/css/ycoronel.adminlte.min.css',
    'resources/ui/css/ycoronel.OverlayScrollbars.min.css',
], 'public/css/ycoronelui.css')
    .scripts([
        'resources/ui/js/ycoronel.jquery.min.js',
     //   'resources/ui/js/ycoronel.bootstrap.bundle.min.js',
     //   'resources/ui/js/ycoronel.Chart.min.js',
        'resources/ui/js/ycoronel.jquery.overlayScrollbars.min.js',
        'resources/ui/js/ycoronel.adminlte.js',
    ],'public/js/ycoronelui.js');
