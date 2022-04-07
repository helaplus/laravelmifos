<?php


namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;

class LoanController extends Controller {

    public static function getLoan($loan_id){
        $endpoint = "loans/".$loan_id;
        $options = "associations=all";
        return MifosHelperController::MifosGetTransaction($endpoint,$options);
    }

    public static function getLoanProduct($product_id){
        $endpoint = "loanproducts/".$product_id;
        $options = "template=true";
        return MifosHelperController::MifosGetTransaction($endpoint,$options);
    }

    public static function applyLoan($data){
        $endpoint = "loans";
        return MifosHelperController::MifosPostTransaction($endpoint, $data);
    }

    public static function approveLoan($loan_id,$data){
        $options = 'command=approve';
        $endpoint = "loans/".$loan_id;
        return MifosHelperController::MifosPostTransaction($endpoint, $data,$options);
    }

    public static function disburseLoan($loan_id,$data){
        $options = 'command=disburse';
        $endpoint = "loans/".$loan_id;
        return MifosHelperController::MifosPostTransaction($endpoint, $data,$options);
    }

    public static function getLoanBalance($client_id){
        $loanAccounts = ClientController::getClientLoanAccounts($client_id);
        $balance = 0;
        foreach ($loanAccounts as $lA){
            if($lA->status->id ==300){
                $balance = $balance+$lA->loanBalance;
            }
        }
    }
}