<?php
namespace App\Classes;

use App\Bahranda\Enum\Months;
use App\Models\Partnership;
use App\Models\Transaction;
use App\Models\UserActivity;
use App\Models\Wallet;
use App\Models\WalletRequest;
use App\Response\BahrandaResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserDashboardClass
{
    use BahrandaResponse;

    public function __construct()
    {
        $this->walletRepo = new  Wallet;
        $this->transactionRepo = new  Transaction;
        $this->dealRepo = new Partnership ;
        $this->activityRepo = new UserActivity() ;
        $this->withdrawalRequest = new WalletRequest();
    }
    public function getUserDashboardInfo($user)
    {
        //get wallet
        $walletInfo = $user->wallet;
        //fetch 10 last partnerships
        $walletInfo = $user->deal;
        //transactions
        $dashboard ['account_summary'] = [
                        "total_deals" => $this->dealRepo->where('user_id',$user->id)->count() ?? 0,
                        "total_deals_amount" => $this->dealRepo->where('user_id',$user->id)->sum('amount'),
                        "withdrawn" => $this->walletRepo->where('user_id',$user->id)->first()->withdrawn,
                        "active_deals" => $this->dealRepo->where('user_id',$user->id)->where('status',1)->sum('amount'),
        ];
        //get summary of transactions
        // $dateFrom = date("Y-01-01 00:00:00");
        // $dateTo = date("Y-12-31 00:00:00");

        // $dealstransactions =  $this->transactionRepo->where('user_id',$user->id)
        // ->where('type',"deals")->whereBetween('created_at', [$dateFrom, $dateTo])->select(DB::raw('sum(amount) as `deals`'), DB::raw('DATE_FORMAT(created_at, "%M") as month'))->groupBy('month')->get();

        // $withdrawalTransactions =  $this->transactionRepo->where('user_id',$user->id)->where('type',"withdrawal")->whereBetween('created_at', [$dateFrom, $dateTo])->select(DB::raw('sum(amount) as `withdrawal`'), DB::raw('DATE_FORMAT(created_at, "%M") as month'))->groupBy('month')->get();

        $dashboard["monthly_expenditure"] = $this->getMonthlyExpenditure($user);
        $dashboard["user_activities"] = $this->activityRepo->where('user_id',$user->id)->latest()->get()->take(15);
   

     return $this->fetch("Dashboard details fetched successfully",$dashboard,"data");
       

        
    }

    public function getMonthlyExpenditure($user)
    {
        $months = ["Jan" => 1,"Feb" => 2,"Mar" => 3,"Apr" => 4,"May" => 5,"Jun" => 6,"Jul" => 7,"Aug" => 8,"Sept" => 9,"Oct" => 10,"Nov" => 11,"Dec" => 12];

        $invested = [];
        $withdrawn = [];

        foreach($months as $month_name => $index)
        {
            $from_date = date("Y-$index-01",strtotime('now'));
            $end_date = date("Y-$index-31",strtotime('now'));
             array_push($invested , $this->dealRepo->where('user_id',$user->id)->whereBetween('created_at',[$from_date,$end_date])->sum('amount'));
            array_push($withdrawn ,$this->withdrawalRequest->where('user_id',$user->id)->where('status','paid')->whereBetween('created_at',[$from_date,$end_date])->sum('amount'));
           

        }
        return compact("invested","withdrawn");
    }
}