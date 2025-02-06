<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Actions\Concerns;

abstract class BaseAction
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function run(...$args): mixed
    {
        /** @phpstan-ignore-next-line */
        return static::make()->handle(...$args);
    }
}
