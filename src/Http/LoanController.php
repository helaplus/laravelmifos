<?php

namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;

class ClientController extends Controller {
    public static function getLoanProduct($product_id){
        $endpoint = "loanproducts/".$product_id;
        $options = "template=true";
        return MifosHelperController::MifosGetTransaction($endpoint,$options);
    }
}