<?php

namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;

class ClientController extends Controller {


    public static function create($data)
    {
        $endpoint = "clients";
        return MifosHelperController::MifosPostTransaction($endpoint, $data);
    }

}