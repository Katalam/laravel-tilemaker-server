<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Katalam\Tilemaker\Actions\Concerns\BaseAction;
use Katalam\Tilemaker\Contracts\GetTileInterface;
use Katalam\Tilemaker\Dtos\Tile;

class GetTile extends BaseAction implements GetTileInterface
{
    public function handle(int $zoom, int $col, int $tmsY): ?Tile
    {
        $object = DB::connection(Config::get('tilemaker-server.database.connection'))
            ->query()
            ->select('tile_data')
            ->from('tiles')
            ->where('zoom_level', $zoom)
            ->where('tile_column', $col)
            ->where('tile_row', $tmsY)
            ->first();

        if ($object === null) {
            return null;
        }

        return new Tile(
            $zoom,
            $col,
            $tmsY,
            $object->tile_data
        );
    }
}
