<?php
namespace App\Classes;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class UserMgtClass
{
    public function __construct()
    {
        $this->userRepo = new User;
        $this->userTransactionClass = new UserTransactionClass();
         $this->walletHistoryRepo = new WalletHistory();
        $this->walletRepo = new Wallet();

    }

    public function getUserList($keyword=null)
    {
         $filter = $this->userRepo->query();

         if($keyword){
           
            $filter =  $filter->where('email','like','%'.$keyword.'%')
              ->orWhere(function($qx) use ($keyword) {
                $name  = explode(" ",$keyword);
                if(isset($name[1])){
                    $qx->where('first_name','like','%'.$name[0].'%')
                    ->orWhere('last_name','like','%'.$name[1].'%')
                    ->orWhere('last_name','like','%'.$name[0].'%')
                    ->orWhere('first_name','like','%'.$name[1].'%');
                }else{
                    $qx->where('first_name','like','%'.$keyword.'%')
                    ->orWhere('last_name','like','%'.$keyword.'%');
                }
               
              
            });
                        
        }
         //get count
         $filterclone = clone $filter;
         $total_user = $filterclone->count();
         $active_user = $filterclone->where('active',1)->count();
         
         $users = $filter->orderBy('id','desc')->paginate(10);
         return ['status' => "success","message" => "Fetched succesfully","data" => ["users" => $users,"total_user" => $total_user,"active_user" => $active_user]];
    }

      public function getUsers()
    {
        
         $users = User::orderBy('first_name','asc')->get();
         return $users;
    }


    public function getUserDetails($user)
    {
        $user =  $this->userRepo->whereId($user)->first();
        if($user)
        {
            return ["status" => "success","message" => "Admin details fetched successfully","user" => $user];
        }else{
            return ["status" => "error","message" => "Error fetching admin"];
        }
    }

    public function changeUserStatus($user,$user_status)
    {

        $user =  $this->userRepo->whereId($user)->first();
        if($user)
        {
            $message = "Invalid command";
            if($user_status == "suspend")
            {
                $user->active = 0;
                $message= "User suspended succesfully";
            }
            if($user_status == "activate")
            {
                $user->active = 1;
                $message = "User activated successfully";
            }

            $user->save();
            return ["status" => "success","message"=> $message];

        }else{
            return ["status" => "error","message"=> "User not found"];
        }
    }

    public function fundUser($userId,$amount) {
        
           $user = User::where('id',$userId)->first();
            if(!$user ) {
                return ["status" => "error", "message" => "user not found"];
            }
          
            $wallet = $this->walletRepo->where('user_id',$user->id)->first();

            if(!$wallet)
            {
                 return ["status" => "error", "message" => "unable to debit wallet"];
            }
          $reference = UserMgtClass::quickRandom(20);
           DB::transaction(function () use ($user, $amount,$wallet,$reference) {
                    try {
                    $wallet->balance = $wallet->balance +$amount;
                    $wallet->save();
                       
                    $this->userTransactionClass->storeTransaction($user,$reference,$amount,'funding'," funding  from admin");

                    $this->walletHistoryRepo->create([
                        "user_id" => $user->id,
                        "remark" =>  "₦" . number_format($amount) . " has been added to your account by admin as funding",
                        "status" => "credit",
                        "amount" => $amount
                    ]);
                }catch(Exception $e) {

                     throw new Error("Unable to fund user");
                }
            });
        return ['status' => "success", "message" => "User wallet funded successfully"];
    }
    // purchase a commodity for 

public static function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}
}