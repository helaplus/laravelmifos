<?php

namespace Helaplus\Laravelmifos\Http\Controllers;

use Helaplus\Laravelmifos\Http\Controllers\MifosHelperController;

class ClientController extends Controller {


    public static function create($data)
    {
        $endpoint = "clients";
        return MifosHelperController::MifosPostTransaction($endpoint, $data);
    }

}