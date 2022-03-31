<?php


namespace Helaplus\Laravelmifos\Http;


use Illuminate\Support\Facades\Http;

class MifosHelperController extends Controller {


    public static function MifosPostTransaction($endpoint,$data,$options=""){
        if(strlen($options)>0){ 
            $options = "&".$options;
        }
        $url = config('laravelmifos.mifos_url') . "fineract-provider/api/v1/".$endpoint."?tenantIdentifier=" .config('laravelmifos.mifos_tenant').$options;
        return Http::withHeaders(
            [
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($data)
            ]
        )->withBasicAuth(config('laravelmifos.mifos_username'),config('laravelmifos.mifos_password'))->post($url,$data);
    }

}







