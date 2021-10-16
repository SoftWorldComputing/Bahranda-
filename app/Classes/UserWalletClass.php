<?php
namespace App\Classes;

use App\Exceptions\WalletNotFoundException;
use App\Http\Resources\BankInfoResource;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Response\BahrandaResponse;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Classes\UserTransactionClass;

class UserWalletClass
{

    use BahrandaResponse;

    public function __construct()
    {
       $this->walletRepo = new Wallet();
       $this->walletHistoryRepo = new WalletHistory();
       $this->userTransactionClass = new UserTransactionClass();
    
    }

    public function getUserWallet($user)
    {
        $data = [];
        $wallet_data = $this->walletRepo->whereUserId($user->id)->select(['balance','withdrawn','wallet_pin'])->first();
        $data['wallet_balance'] = $wallet_data->balance;
        $data['amount_withdrawn'] = $wallet_data->withdrawn;
        $data['has_set_pin'] = !(is_null($wallet_data['wallet_pin']) || empty($wallet_data['wallet_pin']));
        $data['bank_details'] =  new BankInfoResource($user->accountInfo);

        return $this->fetch("User wallet details fetchd",$data,"wallet_details");
      
    }

    public function getWalletHistory($user)
    {
       
        $wallet_history = $user->walletHistory()->paginate(20);

        return $this->fetch("User wallet history fetched successfully",$wallet_history,"wallet_histories");

    }

    public function getWalletRequest($user)
    {
       
        $wallet_request = $user->walletRequest()->paginate(20);

        $data['wallet_request'] = $wallet_request;
       
        return $this->fetch("User wallet requests fetched successfully",$wallet_request,"wallet_requests");

    }

    public function requestWithdrawal($user,$amount,$user_pin)
    {   
        $balance = $user->wallet->balance ?? 0;
        $pin = $user->wallet->wallet_pin ?? "";
        $has_pending = $user->walletRequest()->where('status','pending')->exists();

        if(empty($pin) || $pin != $user_pin )
        {
            //return pin error
            return $this->error("Invalid wallet pin",400);
        }

        if($amount <= 0)
        {
            //return less than or equal to zero error
            return $this->error("Cannot request for amount less than 0",400);
        }
        if(($balance <= 0))
        {
            return $this->error("Insufficent balance",400);
        }
        if(  $amount  > $balance)
        {
            //return amount greater tan balnce error
            return $this->error("Amount requested is greater than balance",400);
        }

        if($has_pending )
        {
            //return has pending  error
            return $this->error("You have a pending request, please wait till that request is resolved thanks",400);
        }

        //save
        $user->walletRequest()->create([
            "user_id" => $user->id,
            "amount" => $amount,
            "status" => "pending",
        ]);
        $user->userActivities()->create(["remark" => config('activity.users.withdrawal_request'),"status" => "completed"]);
        
        return $this->created("Withdrawal request submitted successfully","ok","submitted");
    }

    public function  setPin($user,$pin)
    {
        $check = !$user->wallet->wallet_pin == "";
        if(is_null($pin) || empty($pin))
        {
            return $this->error("Invalid pin data sent",400);
        }
        if($check)
        {
            return $this->error("User pin already set",400);
        }

        $user->wallet()->update([
            "wallet_pin" => $pin
        ]);
        $user->userActivities()->create(["remark" => config('activity.users.user_set_pin'),"status" => "completed"]);

        return $this->created("Pin set successfully","ok","submitted");
    }

    public function updateAccountInfo($user,$bank_name,$account_name,$account_no,$user_pin)
    {
        $pin = $user->wallet->wallet_pin ?? "";

        if(empty($pin) || $pin != $user_pin )
        {
            //return pin error
            return $this->error("Invalid wallet pin",400);
        }

        $user->accountInfo()->updateOrCreate(['user_id' => $user->id],[
                "bank_name" => $bank_name,
                "account_name" => $account_name,
                "account_no" => $account_no,
                "user_id" => $user->id
        ]);
        $user->userActivities()->create(["remark" => config('activity.users.account_info_update'),"status" => "completed"]);
        return $this->created("Account balance updated succesfully","ok","submitted");
    }


    public function fundWallet($user,$transactionRef,$amount)
    {
          $verify = $this->userTransactionClass ->verifyPayment($amount, $transactionRef);

          if($verify)
          {
               DB::transaction(function () use ($user, $transactionRef, $amount) {
                    try {   
                        // funding user wallet and storing the transaction
                       $wallet = $this->walletRepo->where('user_id',$user->id)->first();
                       if($wallet)
                       {
                           $wallet->balance =  $wallet->balance + $amount;
                           $wallet->save();

                           // wallet history
                            $this->walletHistoryRepo->create([
                                "user_id" => $user->id,
                                "remark" =>  "₦" . number_format($amount) . " has been funded into your account from card payment ",
                                "status" => "credit",
                                "amount" => $amount
                            ]);

                          $this->userTransactionClass->storeTransaction($user,$transactionRef,$amount,'funding',"Fund wallet with $amount");
                       }else{
                            throw new Error('user doesnt have a wallet');
                       }
                        //generate receipt an
                        //
                    } catch (\Exception $e) {

                        throw new WalletNotFoundException('wallet not found');
                    }
                });

                $user->userActivities()->create(["remark" => config('activity.users.user_funding') + " with $amount", "status" => "completed"]);

                return $this->created("Wallet funded successfully", "true", "funded");
          }else{
                return $this->error("cannot verify transaction", 400);
          }
             
    }


}