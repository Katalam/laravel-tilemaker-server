<?php

declare(strict_types=1);

namespace Katalam\Tilemaker;

use Katalam\Tilemaker\Commands\TilemakerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TilemakerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-tilemaker-server')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_tilemaker_server_table')
            ->hasCommand(TilemakerCommand::class);
    }
}
