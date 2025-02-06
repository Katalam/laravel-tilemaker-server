<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Actions;

use Katalam\Tilemaker\Actions\Concerns\BaseAction;
use Katalam\Tilemaker\Contracts\CalculateTileRowInterface;

class CalculateTileRow extends BaseAction implements CalculateTileRowInterface
{
    public function handle(int $zoom, int $y): int
    {
        /*
         * 2 ** zoom is the number of tiles horizontally
         * 2 ** zoom - 1 is the last tile vertically
         * y is the offset to get the TMS Y
         *
         * @see https://wiki.openstreetmap.org/wiki/Slippy_map_tilenames
         */

        return (2 ** $zoom) - $y - 1;
    }
}
