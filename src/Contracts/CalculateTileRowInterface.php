<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Contracts;

interface CalculateTileRowInterface
{
    public function handle(int $zoom, int $y): int;
}
