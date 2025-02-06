<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Dtos;

readonly class Tile
{
    public function __construct(
        public int $zoomLevel,
        public int $column,
        public int $row,
        public string $data,
    ) {}
}
