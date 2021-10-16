<?php
namespace App\Classes;
use App\Models\Partnership;
use App\Models\WalletRequest;

class AccountingMgtClass {

    public function __construct()
    {
        $this->partnershipRepo = new Partnership;
        $this->withdrawalRequestRepo = new WalletRequest();

    }

    public function allAccounts($keyword,$date_from,$date_to)
    {
        $filter = $this->partnershipRepo->newQuery();
        if($keyword)
        {
            $filter = $filter->whereHas('commodity',function($q) use($keyword){
                        $q->where('commodity_name','like','%'.$keyword.'%');
            });
        }
        if($date_from && $date_to)
        {
            $filter = $filter->whereBetween('created_at',[$date_from,$date_to]);
        }

        $profit_made = clone $filter;
        $no_of_closed_deals = clone $filter;
        $profit_made = $profit_made->where('status',4)->sum('profit');
        $no_of_closed_deals = $no_of_closed_deals->where('status',4)->count();
       $accountings = $filter->where('status',4)->paginate(30);
       
    
        return ["status" => "success","message" => "fetched successfully","accounting" => ['accountings' => $accountings,'profit_made' => $profit_made,'no_of_closed_deals' => $no_of_closed_deals]];
    }

    public function fetchWithdrawalRequestData($keyword,$date_from,$date_to)
    {
        $filter = $this->withdrawalRequestRepo->newQuery();
        if($keyword)
        {
            $filter = $filter->whereHas('user',function($q) use($keyword){
                        $q->where('first_name','like','%'.$keyword.'%')
                          ->orWhere('last_name','like','%'.$keyword.'%');
            });
        }
        if($date_from && $date_to)
        {
            $filter = $filter->whereBetween('created_at',[$date_from,$date_to]);
        }

        $paid = clone $filter;
        $pending = clone $filter;
        $denied = clone $filter;
        $total_balance = clone $filter;

        $data['paid_count'] = $paid->where('status','paid')->count();
        $data['pending_count'] = $pending->where('status','pending')->count();
        $data['denied'] = $denied->where('status','denied')->count();
        $data['total_balance'] = $total_balance->where('status','paid')->sum('amount');
         $data['all'] = $filter->paginate(30);
       
    
        return ["status" => "success","message" => "fetched successfully","withdrawal_requests" => $data];
    }
    public function changeWithdrawalStatus($withdrawal,$status)
    {
        $withdrawal =  $this->withdrawalRequestRepo->where('id',$withdrawal)->first();
        if($withdrawal)
        {
            $user = $withdrawal->user;
            if($status == "paid")
            {
               
               $balance =  $user->wallet()->update([
                    'balance' =>  floor($user->wallet->balance - $withdrawal->amount),
                    "withdrawn" => floor($user->wallet->withdrawn + $withdrawal->amount),
                ]);

                
                //wallet history
                $user->walletHistory()->create([
                    "user_id" => $user->id,
                    "remark" => "Withdrawal request of ".number_format($withdrawal->amount). ' was authorized in your account and your balance remains '.number_format($user->wallet->balance - $withdrawal->amount),
                    "status" => "completed",
                    "amount" => $withdrawal->amount
                ]);
            }else{
                $user->walletHistory()->create([
                    "user_id" => $user->id,
                    "remark" => "Withdrawal request of ".number_format($withdrawal->amount). ' was denied in your account and your balance remains '.number_format($user->wallet->balance),
                    "status" => "denied",
                    "amount" => $withdrawal->amount
                ]);
            }
            $withdrawal->update(['status' => $status]);
          return ["status" => "success","message" => "Withdrawal status updated successfully"];

        }
        return ["status" => "error","message" => "Unable to update withdrawal status"];

    }
}
