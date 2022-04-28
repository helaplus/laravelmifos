<?php

namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;
use Illuminate\Support\Facades\Http;

class DatatablesController extends Controller {


    public static function create($client_id,$data)
    {
        $endpoint = "datatables/".$client_id;
        $options = "genericResultSet=true"; 
        return MifosHelperController::MifosPostTransaction($endpoint, $data,$options);
    }

}