<?php

declare(strict_types=1);

namespace Katalam\Tilemaker\Http\Controllers;

use Illuminate\Routing\Controller;
use Katalam\Tilemaker\Contracts\GetMetaDataInterface;

class MetaDataController extends Controller
{
    public function __invoke(GetMetaDataInterface $getMetaDataAction)
    {
        $data = $getMetaDataAction->handle();

        return response()->json($data);
    }
}
