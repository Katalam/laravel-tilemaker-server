<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Http\Controllers;

use Illuminate\Routing\Controller;
use Katalam\Tilemaker\Contracts\CalculateTileRowInterface;
use Katalam\Tilemaker\Contracts\GetTileInterface;
use Katalam\Tilemaker\Tilemaker;

class TileController extends Controller
{
    public function __invoke(int $zoom, int $col, int $y, CalculateTileRowInterface $calculateTileRowAction, GetTileInterface $getTileAction)
    {
        $tmsY = $calculateTileRowAction->handle($zoom, $y);

        $tile = $getTileAction->handle($zoom, $col, $tmsY);

        if ($tile === null) {
            return response(Tilemaker::getPackedEmptyTile(), headers: Tilemaker::$responseHeaders);
        }

        return response($tile->data, headers: Tilemaker::$responseHeaders);
    }
}
