<?php


namespace Helaplus\Laravelmifos\Http;


use Illuminate\Support\Facades\Http;

class MifosHelperController extends Controller {


    public static function MifosPostTransaction($endpoint,$data,$options=""){
        if(strlen($options)>0){
            $options = "&".$options;
        }
        $url = config('laravelmifos.mifos_url') . "fineract-provider/api/v1/".$endpoint."?tenantIdentifier=" .config('laravelmifos.mifos_tenant').$options;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, config('laravelmifos.mifos_username').':'.config('laravelmifos.mifos_password'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }
        curl_close($ch);

        $response = json_decode($data);

        return $response;

        //        return Http::withHeaders(
//            [
//                'Content-Type' => 'application/json',
//                'Content-Length' => strlen($data)
//            ]
//        )->withBasicAuth(config('laravelmifos.mifos_username'),config('laravelmifos.mifos_password'))->post($url,$data);
    }

}







