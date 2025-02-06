<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Contracts;

use Katalam\Tilemaker\Dtos\Tile;

interface GetTileInterface
{
    public function handle(int $zoom, int $col, int $tmsY): ?Tile;
}
