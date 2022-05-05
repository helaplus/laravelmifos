<?php

namespace Helaplus\Laravelmifos\Http;

use Carbon\Carbon;
use Helaplus\Laravelmifos\Http\MifosHelperController;
use Helaplus\Sms\Http\Controllers\SmsController;
use Helaplus\Sms\Http\Controllers\WasilianaSmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MpesaController extends Controller
{

    public function c2bReceiver()
    {

    }

    public function stkReceiver(Request $request)
    {
        $data = self::getStkInputData($request);
        $processed = self::processRepayment($data);
        return $processed;
    }

    public function processRepayment($data){
        //get client
        $client = ClientController::getClientByPhone($data['phone']);
        //get Loan accounts
        $loanAccounts = ClientController::getClientLoanAccounts($client->id);
        $loan_payment_received = $data['amount'];
        foreach ($loanAccounts as $la) {
            if (($la->status->id == 300) && ($loan_payment_received>0)) {
                if(($la->loanBalance <= $loan_payment_received)){
                    $loan_payment_received = $loan_payment_received - $la->loanBalance;
                    $amount = $la->loanBalance;
                }else{
                    $amount = $loan_payment_received;
                    $loan_payment_received=0;
                }
                // get repayment details
                $repayment_data = [];
                $repayment_data['dateFormat'] = 'dd MMMM yyyy';
                $repayment_data['locale'] = 'en_GB';
                $transaction_time = $data['transaction_time'];
                $carbon_time = substr($transaction_time,0,4)."-".substr($transaction_time,4,2)."-".substr($transaction_time,6,2);
                $repayment_data['transactionDate'] = Carbon::parse($carbon_time)->format('j F Y');
                $repayment_data['transactionAmount'] = $amount;
                $repayment_data['paymentTypeId'] = env('PAYMENT_TYPE', '1');
                $repayment_data['note'] = 'Payment';
                $repayment_data['accountNumber'] = $data['phone'];
                $repayment_data['receiptNumber'] = $data['transaction_id'];

                // json encode repayment details
                $loan_data = json_encode($repayment_data);

                $loanPayment = LoanController::repayLoan($la->id,$loan_data);

                if(!isset($loanPayment->changes->transactionAmount)){
                    $response = FALSE;
                }else{
                    //send sms
                    $balance = $la->loanBalance - $amount;
                    if($amount == $la->loanBalance){
                        $type = 2;
                    }else{
                        $type = 1;
                    }
                    $rsp = self::sendRepaymentSms($data,$amount,$type,$balance);

                    $response = $rsp;
                }

            }

            if($loan_payment_received ==0){
                break;
            }
        }

        return $response;
    }

    public function sendRepaymentSms($data,$amount,$type,$balance){
        //partial repayment
        if($type=1){
            $sms = "Congratulations, Kshs ".$amount." has been used to partially pay your Bloom Agent Finance Loan. Outstanding balance is Kshs. ".$balance.". Borrow and pay every day to improve your credit rating with Asante Finance";
        }else{
            //full repayment
            $sms = "Congratulations, you have fully repaid your Bloom Agent Finance Loan of Kshs. ".$amount.". You can borrow again and pay every day to improve your credit rating with Asante Finance";
        }
        return SmsController::sendSms($data['phone'],$sms);
    }

    public function getStkInputData($request)
    {
        $request = $request->all();
        $items = $request['Body']['stkCallback']['CallbackMetadata']['Item'];
        $data['phone'] = $items[4]['Value'];
        $data['transaction_id'] = $items[1]['Value'];
        $data['amount'] = $items[0]['Value'];
        $data['account_no'] = $items[4]['Value'];
        $data['externalId'] = $items[4]['Value'];
        $data['transaction_time'] = $items[3]['Value'];
        $data['paybill'] = $items[4]['Value'];
        return $data;
    }

}

