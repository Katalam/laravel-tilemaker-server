<?php

declare(strict_types=1);

use Katalam\Tilemaker\Actions\CalculateTileRow;
use Katalam\Tilemaker\Actions\GetMetaData;
use Katalam\Tilemaker\Actions\GetTile;
use Katalam\Tilemaker\Contracts\CalculateTileRowInterface;
use Katalam\Tilemaker\Contracts\GetMetaDataInterface;
use Katalam\Tilemaker\Contracts\GetTileInterface;
use Katalam\Tilemaker\Dtos\Tile;
use Katalam\Tilemaker\Tilemaker;

describe('singletons', function () {
    test('all singletons are registered', function () {
        expect(app(CalculateTileRowInterface::class))->toBeInstanceOf(CalculateTileRow::class)
            ->and(app(GetMetaDataInterface::class))->toBeInstanceOf(GetMetaData::class)
            ->and(app(GetTileInterface::class))->toBeInstanceOf(GetTile::class);
    });

    test('can replace tile row calculator', function () {
        $class = new class implements CalculateTileRowInterface
        {
            public function handle(int $zoom, int $y): int
            {
                return 1337;
            }
        };

        Tilemaker::calculateTileRowUsing(static fn () => $class);

        expect(app(CalculateTileRowInterface::class)->handle(1, 1))->toBe(1337);
    });

    test('can replace get meta data', function () {
        $class = new class implements GetMetaDataInterface
        {
            public function handle(): array
            {
                return ['foo' => 'bar'];
            }
        };

        Tilemaker::getMetaDataUsing(static fn () => $class);

        expect(app(GetMetaDataInterface::class)->handle())->toBe(['foo' => 'bar']);
    });

    test('can replace get tile', function () {
        $class = new class implements GetTileInterface
        {
            public function handle(int $zoom, int $col, int $tmsY): ?Tile
            {
                return new Tile($zoom, $col, $tmsY, 'foo');
            }
        };

        Tilemaker::getTileUsing(static fn () => $class);

        $tile = app(GetTileInterface::class)->handle(1, 2, 3);

        expect($tile)->toBeInstanceOf(Tile::class)
            ->and($tile->zoomLevel)->toBe(1)
            ->and($tile->column)->toBe(2)
            ->and($tile->row)->toBe(3)
            ->and($tile->data)->toBe('foo');
    });
});

describe('setter and getter', function () {
    test('packed empty tile', function () {
        expect(Tilemaker::getPackedEmptyTile())->toBe(pack('H*', Tilemaker::$emptyTile));
    });

    test('ignore routes', function () {
        Tilemaker::ignoreRoutes();

        expect(Tilemaker::$registerRoutes)->toBeFalse();
    });

    test('use response headers', function () {
        Tilemaker::useResponseHeaders(['foo' => 'bar']);

        expect(Tilemaker::$responseHeaders)->toBe(['foo' => 'bar']);
    });
});
