<?php
namespace App\Classes;

use App\Exceptions\UnableToCompletePurchase;
use App\Http\Resources\DealResource;
use App\Http\Resources\SingleDealResource;
use App\Models\Partnership;
use App\Models\PartnershipBreakdown;
use App\Response\BahrandaResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserDealsClass
{
  use BahrandaResponse;

  public function __construct()
  {
      $this->dealRepo = new Partnership;
  }

  public function fetchAllDeals($user)
  {
      $data = [];
      $data['deals'] = DealResource::collection($this->dealRepo->where('user_id',$user->id)->orderBy('created_at','desc')->paginate(20));
      //get active deals
      $data['active_deals'] = $this->dealRepo->where('user_id',$user->id)->whereStatus(1)->count();
      $data['cancelled_deals'] = $this->dealRepo->where('user_id',$user->id)->whereStatus(2)->count();
      $data['completed_deals'] = $this->dealRepo->where('user_id',$user->id)->whereStatus(3)->count();
      $data['closed_deals'] = $this->dealRepo->where('user_id',$user->id)->whereStatus(4)->count();

      $data['total_investment'] = $this->dealRepo->where('user_id',$user->id)->where('status','!=',4)->sum('amount');
      $data['total_profit'] = $this->dealRepo->where('user_id',$user->id)->where('status','!=',4)->sum('profit');

      return $this->fetch("All deals fetched",$data,"deals");

  }

  public function getSingleDeal($user,$dealId)
  {
        //get deal that belongs to the user
        $deal = $this->dealRepo->whereUserId($user->id)->where('id',$dealId)->first();
        if($deal)
        {
            $data = new SingleDealResource($deal);

            return $this->fetch("Single details fetched successfully",$data,"deal");
        }
        return $this->error("Deal not found",404);
  }
}