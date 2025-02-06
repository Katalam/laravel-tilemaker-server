<?php

declare(strict_types=1);

namespace Katalam\Tilemaker;

use Katalam\Tilemaker\Actions\CalculateTileRow;
use Katalam\Tilemaker\Actions\GetMetaData;
use Katalam\Tilemaker\Actions\GetTile;
use Katalam\Tilemaker\Commands\InstallCommand;
use Katalam\Tilemaker\Contracts\CalculateTileRowInterface;
use Katalam\Tilemaker\Contracts\GetMetaDataInterface;
use Katalam\Tilemaker\Contracts\GetTileInterface;
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
            ->hasRoute('api')
            ->hasCommand(InstallCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(CalculateTileRowInterface::class, CalculateTileRow::class);
        $this->app->singleton(GetMetaDataInterface::class, GetMetaData::class);
        $this->app->singleton(GetTileInterface::class, GetTile::class);
    }
}
