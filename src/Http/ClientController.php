<?php

namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;

class ClientController extends Controller {


    public static function create($data)
    {
        $endpoint = "clients";
        return MifosHelperController::MifosPostTransaction($endpoint, $data);
    }

    public static function getClientByPhone($phone){
        $user = FALSE;
        $endpoint = 'search';
        $options = "exactMatch=false&query=" . $phone . "&resource=clients";
        // Get client
        $post_data = "";
        $client = MifosHelperController::MifosGetTransaction($endpoint,$options);
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
        return $user;
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