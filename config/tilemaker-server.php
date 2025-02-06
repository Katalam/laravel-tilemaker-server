<?php

declare(strict_types=1);

// config for Katalam/Tilemaker
return [
    'database' => [
        'connection' => env('TILEMAKER_DB_CONNECTION', 'tiles'),
    ],

    'routes' => [
        'prefix' => env('TILEMAKER_ROUTE_PREFIX', 'tiles'),
        'as' => env('TILEMAKER_ROUTE_AS', 'tiles.'),
    ],
];
