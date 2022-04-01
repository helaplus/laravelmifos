<?php


namespace Helaplus\Laravelmifos\Http;

use Helaplus\Laravelmifos\Http\MifosHelperController;

class LoanController extends Controller {
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
}