<?php

declare(strict_types=1);

use Katalam\Tilemaker\Contracts\GetMetaDataInterface;

use function Pest\Laravel\get;
use function Pest\Laravel\mock;

test('can return meta data', function () {
    mock(GetMetaDataInterface::class)
        ->shouldReceive('handle')
        ->andReturn([
            'foo' => 'bar',
        ]);

    get('meta-data')
        ->assertOk()
        ->assertJson([
            'foo' => 'bar',
        ]);
});
