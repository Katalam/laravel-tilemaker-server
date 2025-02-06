<?php

declare(strict_types=1);

use Katalam\Tilemaker\Contracts\GetTileInterface;
use Katalam\Tilemaker\Dtos\Tile;

use function Pest\Laravel\get;
use function Pest\Laravel\mock;

test('can return tile', function () {
    mock(GetTileInterface::class)
        ->shouldReceive('handle')
        ->andReturn(new Tile(1, 2, 3, 'abc'));

    get('1/2/3')
        ->assertOk()
        ->assertSee('abc');
});

test('can return empty tile', function () {
    mock(GetTileInterface::class)
        ->shouldReceive('handle')
        ->andReturn(null);

    get('1/2/3')
        ->assertOk();
});
