<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Katalam\Tilemaker\Http\Controllers\MetaDataController;
use Katalam\Tilemaker\Http\Controllers\TileController;
use Katalam\Tilemaker\TilemakerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            static fn (string $modelName) => 'Katalam\\Tilemaker\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function defineRoutes($router): void
    {
        $router->get('meta-data', MetaDataController::class);
        $router->get('{zoom}/{x}/{y}', TileController::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            TilemakerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }
}
