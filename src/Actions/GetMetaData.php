<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Katalam\Tilemaker\Actions\Concerns\BaseAction;
use Katalam\Tilemaker\Contracts\GetMetaDataInterface;

class GetMetaData extends BaseAction implements GetMetaDataInterface
{
    public function handle(): array
    {
        return DB::connection(Config::get('tilemaker-server.database.connection'))
            ->query()
            ->select(['name', 'value'])
            ->from('metadata')
            ->get()
            ->mapWithKeys(function (object $item) {
                return [$item->name => $item->value];
            })
            ->toArray();
    }
}
