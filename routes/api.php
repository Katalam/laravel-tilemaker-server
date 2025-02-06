<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Katalam\Tilemaker\Http\Controllers\MetaDataController;
use Katalam\Tilemaker\Http\Controllers\TileController;

Route::as(Config::get('tilemaker-server.routes.as'))
    ->prefix(Config::get('tilemaker-server.routes.prefix'))
    ->group(function () {
        Route::get('meta-data', MetaDataController::class)
            ->name('meta-data');

        Route::get('{zoom}/{col}/{y}', TileController::class)
            ->where('zoom', '\d+')
            ->where('col', '\d+')
            ->where('y', '\d+')
            ->name('tiles');
    });
