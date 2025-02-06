<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Katalam\Tilemaker\Tilemaker
 */
class Tilemaker extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Katalam\Tilemaker\Tilemaker::class;
    }
}
