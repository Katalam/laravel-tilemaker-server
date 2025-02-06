<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Commands;

use Illuminate\Console\Command;

class TilemakerCommand extends Command
{
    public $signature = 'laravel-tilemaker-server';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
