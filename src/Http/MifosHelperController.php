<?php


namespace Helaplus\Laravelmifos\Http\Controllers;


use Illuminate\Support\Facades\Http;

class MifosHelperController extends Controller {


    public static function MifosPostTransaction($endpoint,$data){
        $url = "https://webhook.site/0b848d01-d4c2-41ea-a0bf-4e9ebabf5623";

        return Http::withHeaders(
            [
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($data)
            ]
        )->withBasicAuth(config('laravelmifos.mifos_username'),config('laravelmifos.mifos_password'))->post($url,$data); 


    }

}







