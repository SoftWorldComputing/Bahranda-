<?php
namespace App\Classes;
use App\Models\Transaction;

class UserTransactionClass {

    public function __construct()
    {
        $this->transactionRepo = new Transaction();
      
    }
    public function verifyTransaction($amount,$transactionRef)
    {
        $result = array();

        //check transaction already in db
        $transactionCheck = $this->transactionRepo->where('transactionRef',$transactionRef)->count();

        if($transactionCheck > 0)
        {
            return false;
        }
        //The parameter after verify/ is the transaction reference to be verified
        $url =  env('PAYSTACK_URL') . $transactionRef;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . env('PAYSTACK_SECRET_KEY')
            ]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        if ($request) {

            $result = json_decode($request, true);
            if ($result && in_array('data',$result)) {
                if ($result['data']) {
                    //something came in
                    if ($result['data']['status'] == 'success') {

                        if ($amount == ($result['data']['amount'] / 100)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {

                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function storeTransaction($user,$transactionRef, $amount,$type,$description) {
      $transaction =   $this->transactionRepo->create([
            "user_id" => $user->id,
            "type" => $type,
            "transactionRef" => $transactionRef,
            "amount" => $amount,
            "description" => $description
      ]);
      return $transaction;
    }
}