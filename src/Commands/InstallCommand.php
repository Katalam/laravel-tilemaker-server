<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use JsonException;

class InstallCommand extends Command
{
    public $signature = 'tilemaker-server:install';

    public $description = 'Will install the required dependencies for the tilemaker server to serve a map with maplibre-gl.';

    /**
     * @throws JsonException
     */
    public function handle(): int
    {
        static::updateNodePackages(static fn (array $packages) => ['maplibre-gl' => '^5.1.0'] + $packages, false);

        // js
        copy(__DIR__.'/../../stubs/resources/js/map.js', resource_path('js/map.js'));

        // views
        copy(__DIR__.'/../../stubs/resources/views/map.blade.php', resource_path('views/map.blade.php'));

        // css
        copy(__DIR__.'/../../stubs/resources/css/map.css', resource_path('css/map.css'));
        File::append(resource_path('css/app.css'), "@import 'map.css';");

        // fonts
        (new Filesystem)->ensureDirectoryExists(storage_path('app/public/fonts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/storage/fonts', storage_path('app/public/fonts'));

        // style
        copy(__DIR__.'/../../stubs/storage/style.json', storage_path('app/public/style.json'));
        $content = File::get(storage_path('app/public/style.json'));
        $content = str_replace('##URL##', str(config('app.url'))->replaceEnd('/', '')->toString(), $content);
        File::put(storage_path('app/public/style.json'), $content);

        // spec
        copy(__DIR__.'/../../stubs/storage/spec.json', storage_path('app/public/spec.json'));
        $content = File::get(storage_path('app/public/spec.json'));
        $content = str_replace('##URL##', str(config('app.url'))->replaceEnd('/', '')->toString(), $content);
        File::put(storage_path('app/public/spec.json'), $content);

        $this->comment('All done');

        return self::SUCCESS;
    }

    /**
     * Update the dependencies in the "package.json" file.
     *
     * @throws JsonException
     */
    protected static function updateNodePackages(callable $callback, bool $dev = true): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true, 512, JSON_THROW_ON_ERROR);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
