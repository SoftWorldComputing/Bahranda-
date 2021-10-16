<?php
namespace App\Classes;

use App\Exceptions\UnableToCompletePurchase;
use App\Http\Resources\CommoditiesResource;
use App\Http\Resources\SingleCommodityDetails;
use App\Mail\AdminOrderReceipt;
use App\Mail\OrderReceipt;
use App\Models\Commodity;
use App\Models\Partnership;
use App\Models\PartnershipBreakdown;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Response\BahrandaResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Classes\UserTransactionClass;
use Illuminate\Support\Str;
class UserCommodityClass
{
    use BahrandaResponse;

    public function __construct()
    {
        $this->commodityRepo = new Commodity;
        $this->walletRepo = new Wallet();
        $this->dealRepo = new Partnership;
        $this->dealBreakdownRepo = new PartnershipBreakdown();
        $this->walletHistoryRepo = new WalletHistory();
        $this->userTransactionClass = new UserTransactionClass();
    }

    public function getActiveCommodities($page = 1)
    {

        $commodities = CommoditiesResource::collection($this->commodityRepo->whereHas('currentBatch', function ($q) {
            $q->where('in_stock', ">", 0);
        })->paginate(20));

        $commodities = $commodities->response()->getData(true);
        return $this->fetch("Active commodities fetched successfuflly", $commodities, "commodities");
    }

    public function getSingleCommodity($commodityId)
    {
        $check = $this->commodityRepo->where('id', $commodityId)->exists();

        if ($check) {
            $commodity = new SingleCommodityDetails($this->commodityRepo->where('id', $commodityId)->first());
            return $this->fetch("commodity fetched successfuflly", $commodity, "commodity");
        } else {
            return $this->error("Could not found commodity", 404);
        }
    }

    public function calculateCommodityPrice($commodityId, $quantity)
    {
        $check = $this->commodityRepo->where('id', $commodityId)->exists();
        if ($check) {
            $commodity = $this->commodityRepo->where('id', $commodityId)->first();

            if ($quantity < $commodity->minimum_quantity) {
                return $this->error("Minimum quantity purchaseable for this commodity is " . $commodity->minimum_quantity, 400);
            }
            $breakdown = $commodity->getPriceBreakDown($quantity);
            return $this->fetch("breakdown fetched successfuflly", $breakdown, "price_break_down");
        } else {
            return $this->error("Could not found commodity price to calculate breakdown", 400);
        }
    }

    public function getRelatedCommodity()
    {
        //return some commodity
        $commodities = CommoditiesResource::collection($this->commodityRepo->whereAvailability(1)->where('quantity_in_stock', ">", 0)->inRandomOrder()->get()->take(10));

        return $this->fetch("Related commodities fetched successfuflly", $commodities, "commodities");
    }

    public function purchase($user, $commodityId, $transactionReference, $quantity)
    {
        //calculate the amount it is supposed to pay
        $check = $this->commodityRepo->where('availability',1)->where('id', $commodityId)->exists();

        if ($check) {
            $commodity = $this->commodityRepo->where('availability',1)->where('id', $commodityId)->first();

            if ($commodity->currentBatch->in_stock < $quantity) {
                return $this->error("Commodity is not available at time", 400);
            }
            $deal_amount = $commodity->getPriceBreakDown($quantity)['total_deal_cost'];

            if ($quantity < $commodity->minimum_quantity) {
                return $this->error("Minimum quantity purchaseable for this commodity is " . $commodity->minimum_quantity, 400);
            }

            $expected_return = $commodity->getPriceBreakDown($quantity)['expected_return'];
            //perform paystack payment
            $verify = $this->userTransactionClass ->verifyPayment($deal_amount, $transactionReference);
             
            if ($verify) {
                //store deal 
                DB::transaction(function () use ($user, $commodity, $deal_amount, $transactionReference, $quantity, $expected_return) {
                    try {
                        $deal =   $this->dealRepo->create([
                            "user_id" => $user->id,
                            "commodity_id" => $commodity->id,
                            "quantity" => $quantity,
                            "duration" => $commodity->duration,
                            "batch_no" => $commodity->currentBatch->batch_no,
                            "expected_return" => $expected_return,
                            "warehouse_id" => $commodity->warehouses()->first() ? $commodity->warehouses()->first()->id : 0,
                            "status" => 1,
                            "amount" => $deal_amount,
                            "transaction_ref" => $transactionReference
                        ]);

                        $this->dealBreakdownRepo->create([
                            "partnership_id" => $deal->id,
                            "buy_price" => $commodity->buy_price,
                            "sell_price" => $commodity->purchase_price,
                            "state_tax" => $commodity->state_tax,
                            "transportation" => $commodity->transportation,
                            "warehousing" => $commodity->warehousing,
                            "other_costs" => $commodity->other_costs,
                            "profit_margin" => $commodity->profit_margin,
                            "purchase_price" => $commodity->purchase_price,
                        ]);
                        //generate receipt and send to email
                        try {
                            Mail::to($user)->send(new OrderReceipt($commodity, $user, $deal, $transactionReference));
                            // Mail::to(env('SALES_EMAIL', 'sales@bahranda.com'))->send(new AdminOrderReceipt($commodity, $user, $deal));
                        } catch (Exception $e) {
                        }

                        $commodity->currentBatch->update([
                            "in_stock" => $commodity->currentBatch->in_stock - $quantity
                        ]);
                        $this->updateCommodityAvailability($commodity->id, $quantity);

                         $this->userTransactionClass->storeTransaction($user,$transactionReference,$deal_amount,'purchase'," purchases $quantity  $commodity->commodity_name from card");


                        //
                    } catch (\Exception $e) {

                        throw new UnableToCompletePurchase("Unable to complete purchase");
                    }
                });

                $user->userActivities()->create(["remark" => config('activity.users.user_purchase_comm'), "status" => "completed"]);

                return $this->created("Deal purchased successfully", "true", "purchased");
            }
        } else {
            return $this->error("Commodity not available for purchase", 400);
        }
    }

      public function purchaseFromWallet($user, $commodityId, $quantity)
     {
        //calculate the amount it is supposed to pay
          $check = $this->commodityRepo->where('availability',1)->where('id', $commodityId)->exists();

        if ($check) {
            $commodity = $this->commodityRepo->where('availability',1)->where('id', $commodityId)->first();

            if ($commodity->currentBatch->in_stock < $quantity) {
                return $this->error("Commodity is not available at time", 400);
            }
            $deal_amount = $commodity->getPriceBreakDown($quantity)['total_deal_cost'];

            if ($quantity < $commodity->minimum_quantity) {
                return $this->error("Minimum quantity purchaseable for this commodity is " . $commodity->minimum_quantity, 400);
            }

            $expected_return = $commodity->getPriceBreakDown($quantity)['expected_return'];
          
            //check user has enough balance
            $wallet = $this->walletRepo->where('user_id',$user->id)->first();

            if(!$wallet)
            {
                return $this->error("Unable to debit wallet", 400);
            }

            $checkBalance = $wallet->balance > $deal_amount;

            // $reference = Str::random(25);
            $reference = UserMgtClass::quickRandom(25);
             
            if ($checkBalance) {
                //store deal 
                DB::transaction(function () use ($user, $commodity, $deal_amount, $reference, $quantity, $expected_return,$wallet) {
                    try {
                        $deal =   $this->dealRepo->create([
                            "user_id" => $user->id,
                            "commodity_id" => $commodity->id,
                            "quantity" => $quantity,
                            "duration" => $commodity->duration,
                            "batch_no" => $commodity->currentBatch->batch_no,
                            "expected_return" => $expected_return,
                            "warehouse_id" => $commodity->warehouses()->first() ? $commodity->warehouses()->first()->id : 0,
                            "status" => 1,
                            "amount" => $deal_amount,
                            "transaction_ref" => $reference
                        ]);

                        $this->dealBreakdownRepo->create([
                            "partnership_id" => $deal->id,
                            "buy_price" => $commodity->buy_price,
                            "sell_price" => $commodity->purchase_price,
                            "state_tax" => $commodity->state_tax,
                            "transportation" => $commodity->transportation,
                            "warehousing" => $commodity->warehousing,
                            "other_costs" => $commodity->other_costs,
                            "profit_margin" => $commodity->profit_margin,
                            "purchase_price" => $commodity->purchase_price,
                        ]);
                        //generate receipt and send to email
                        try {
                            Mail::to($user)->send(new OrderReceipt($commodity, $user, $deal, $reference));
                            // Mail::to(env('SALES_EMAIL', 'sales@bahranda.com'))->send(new AdminOrderReceipt($commodity, $user, $deal));
                        } catch (Exception $e) {
                        }

                        $commodity->currentBatch->update([
                            "in_stock" => $commodity->currentBatch->in_stock - $quantity
                        ]);
                        $this->updateCommodityAvailability($commodity->id, $quantity);

                        $wallet->balance = $wallet->balance - $deal_amount;
                        $wallet->save();

                $this->userTransactionClass->storeTransaction($user,$reference,$deal_amount,'purchase'," purchases $quantity  $commodity->commodity_name from wallet");

                    $this->walletHistoryRepo->create([
                        "user_id" => $user->id,
                        "remark" =>  "₦" . number_format($deal_amount) . " has been deducted from your account as a payment for purchasing  " . strtolower($commodity->commodity_name) . " deal",
                        "status" => "debit",
                        "amount" => $deal_amount
                    ]);

                        //
                    } catch (\Exception $e) {

                        throw new UnableToCompletePurchase("Unable to complete purchase");
                    }
                });

                $user->userActivities()->create(["remark" => config('activity.users.user_purchase_comm'), "status" => "completed"]);


                return $this->created("Deal purchased successfully", "true", "purchased");
            }else{
                 return $this->error("User does not have enough balance", 400);
            }
        } else {
            return $this->error("Commodity not available for purchase", 400);
        }
    }



    // public function verifyPayment($amount, $reference)
    // {
    //     $result = array();
    //     //The parameter after verify/ is the transaction reference to be verified
    //     $url =  env('PAYSTACK_URL') . $reference;

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt(
    //         $ch,
    //         CURLOPT_HTTPHEADER,
    //         [
    //             'Authorization: Bearer ' . env('PAYSTACK_SECRET_KEY')
    //         ]
    //     );
    //     $request = curl_exec($ch);
    //     curl_close($ch);
    //     if ($request) {

    //         $result = json_decode($request, true);

    //         if ($result) {
    //             if ($result['data']) {
    //                 //something came in
    //                 if ($result['data']['status'] == 'success') {

    //                     if ($amount == ($result['data']['amount'] / 100)) {
    //                         return true;
    //                     } else {
    //                         return false;
    //                     }
    //                 } else {
    //                     return false;
    //                 }
    //             } else {

    //                 return false;
    //             }
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    private function updateCommodityAvailability($commodityId, $quantity)
    {
        $commodity = $this->commodityRepo->where('id', $commodityId)->first();

        if ($commodity->currentBatch->in_stock < $quantity) {
            $commodity->availability = 0;
            $commodity->save();
        }
    }
}
