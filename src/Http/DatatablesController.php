<?php

namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;
use Illuminate\Support\Facades\Http;

class DatatablesController extends Controller {


    public static function create($client_id,$datatable,$data)
    { 
        $endpoint = "datatables/".$datatable."/".$client_id;
        $options = "genericResultSet=true"; 
        return MifosHelperController::MifosPostTransaction($endpoint, $data,$options);
    }

    public static function get($client_id,$datatable)
    { 
        $endpoint = "datatables/".$datatable."/".$client_id;
        $options = "genericResultSet=true";
        return MifosHelperController::MifosGetTransaction($endpoint,$options);
    }

}