<?php return array (
  'apiato/core' => 
  array (
    'aliases' => 
    array (
      'Fractal' => 'Spatie\\Fractal\\Facades\\Fractal',
      'Hashids' => 'Vinkla\\Hashids\\Facades\\Hashids',
    ),
    'providers' => 
    array (
      0 => 'Apiato\\Core\\Providers\\ApiatoServiceProvider',
      1 => 'Vinkla\\Hashids\\HashidsServiceProvider',
      2 => 'Prettus\\Repository\\Providers\\RepositoryServiceProvider',
      3 => 'Spatie\\Fractal\\FractalServiceProvider',
      4 => 'Apiato\\Core\\Generator\\GeneratorsServiceProvider',
    ),
  ),
  'apiato/documentation-generator-container' => 
  array (
    'providers' => 
    array (
      0 => 'App\\Containers\\Vendor\\Documentation\\Providers\\DocumentGeneratorServiceProvider',
    ),
  ),
  'barryvdh/laravel-debugbar' => 
  array (
    'aliases' => 
    array (
      'Debugbar' => 'Barryvdh\\Debugbar\\Facades\\Debugbar',
    ),
    'providers' => 
    array (
      0 => 'Barryvdh\\Debugbar\\ServiceProvider',
    ),
  ),
  'barryvdh/laravel-dompdf' => 
  array (
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
      'Pdf' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
    ),
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
  ),
  'barryvdh/laravel-ide-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'elibyy/tcpdf-laravel' => 
  array (
    'aliases' => 
    array (
      'PDF' => 'Elibyy\\TCPDF\\Facades\\TCPDF',
    ),
    'providers' => 
    array (
      0 => 'Elibyy\\TCPDF\\ServiceProvider',
    ),
  ),
  'itelmenko/laravel-mysql-logger' => 
  array (
    'providers' => 
    array (
      0 => 'ITelmenko\\Logger\\Laravel\\Providers\\MonologMysqlHandlerServiceProvider',
    ),
  ),
  'laravel/passport' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'microweber-deps/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'nunomaduro/termwind' => 
  array (
    'providers' => 
    array (
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ),
  ),
  'owen-it/laravel-auditing' => 
  array (
    'providers' => 
    array (
      0 => 'OwenIt\\Auditing\\AuditingServiceProvider',
    ),
  ),
  'prettus/l5-repository' => 
  array (
    'providers' => 
    array (
      0 => 'Prettus\\Repository\\Providers\\RepositoryServiceProvider',
    ),
  ),
  'rap2hpoutre/laravel-log-viewer' => 
  array (
    'providers' => 
    array (
      0 => 'Rap2hpoutre\\LaravelLogViewer\\LaravelLogViewerServiceProvider',
    ),
  ),
  'rorecek/laravel-ulid' => 
  array (
    'aliases' => 
    array (
      'Ulid' => 'Rorecek\\Ulid\\Facades\\Ulid',
    ),
    'providers' => 
    array (
      0 => 'Rorecek\\Ulid\\UlidServiceProvider',
    ),
  ),
  'simplesoftwareio/simple-qrcode' => 
  array (
    'aliases' => 
    array (
      'QrCode' => 'SimpleSoftwareIO\\QrCode\\Facades\\QrCode',
    ),
    'providers' => 
    array (
      0 => 'SimpleSoftwareIO\\QrCode\\QrCodeServiceProvider',
    ),
  ),
  'spatie/laravel-fractal' => 
  array (
    'aliases' => 
    array (
      'Fractal' => 'Spatie\\Fractal\\Facades\\Fractal',
    ),
    'providers' => 
    array (
      0 => 'Spatie\\Fractal\\FractalServiceProvider',
    ),
  ),
  'spatie/laravel-ignition' => 
  array (
    'aliases' => 
    array (
      'Flare' => 'Spatie\\LaravelIgnition\\Facades\\Flare',
    ),
    'providers' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\IgnitionServiceProvider',
    ),
  ),
  'spatie/laravel-permission' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Permission\\PermissionServiceProvider',
    ),
  ),
  'vinkla/hashids' => 
  array (
    'aliases' => 
    array (
      'Hashids' => 'Vinkla\\Hashids\\Facades\\Hashids',
    ),
    'providers' => 
    array (
      0 => 'Vinkla\\Hashids\\HashidsServiceProvider',
    ),
  ),
);