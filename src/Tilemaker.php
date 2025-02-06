<?php

declare(strict_types=1);

namespace Katalam\Tilemaker;

use Katalam\Tilemaker\Contracts\CalculateTileRowInterface;
use Katalam\Tilemaker\Contracts\GetMetaDataInterface;
use Katalam\Tilemaker\Contracts\GetTileInterface;

class Tilemaker
{
    public static string $emptyTile = '89504e470d0a1a0a0000000d494844520000010000000100010300000066bc3a2500000003504c5445000000a77a3dda0000000174524e530040e6d8660000001f494441541819edc1010d000000c220fba77e0e37600000000000000000e70221000001f5a2bd040000000049454e44ae426082';

    public static bool $registerRoutes = true;

    public static array $responseHeaders = [
        'Content-Encoding' => 'gzip',
        'Content-Type' => 'application/x-protobuf',
    ];

    /**
     * Replace the resolved implementation of CalculateTileRowInterface with a custom implementation.
     */
    public static function calculateTileRowUsing(callable $callback): void
    {
        app()->singleton(CalculateTileRowInterface::class, $callback);
    }

    public static function getMetaDataUsing(callable $callback): void
    {
        app()->singleton(GetMetaDataInterface::class, $callback);
    }

    public static function getTileUsing(callable $callback): void
    {
        app()->singleton(GetTileInterface::class, $callback);
    }

    public static function getPackedEmptyTile(): string
    {
        return pack('H*', static::$emptyTile);
    }

    public static function ignoreRoutes(): void
    {
        static::$registerRoutes = false;
    }

    public static function useResponseHeaders(array $headers): void
    {
        static::$responseHeaders = $headers;
    }
}
