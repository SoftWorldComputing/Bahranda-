<?php

namespace App\Classes;

use App\Exceptions\UnableToCompletePurchase;
use App\Mail\OrderReceipt;
use App\Models\Commodity;
use App\Models\CommodityBatch;
use App\Models\BatchLog;
use App\Models\BatchPriceUpload;
use App\Models\BatchPriceUploadData;
use App\Models\Partnership;
use App\Models\PartnershipBreakdown;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CommodityMgtClass
{

    public function __construct()
    {
        $this->commodityRepo = new Commodity;
        $this->commodityBatchRepo = new CommodityBatch;
        $this->batchLog = new BatchLog;
        $this->batchPriceUploadRepo = new BatchPriceUpload;
        $this->batchPriceUploadDataRepo = new BatchPriceUploadData;
        $this->walletRepo = new Wallet();
        $this->dealRepo = new Partnership();
        $this->dealBreakdownRepo = new PartnershipBreakdown();
        $this->walletHistoryRepo = new WalletHistory();
        $this->userTransactionClass = new UserTransactionClass();
    }

    public function listCommodities($keyword = null, $avail = null)
    {
        $filter = $this->commodityRepo->query();
        if ($keyword) {

            $filter =  $filter->where('commodity_name', 'like', '%' . $keyword . '%')
                ->orWhere(function ($qx) use ($keyword) {
                    $qx->where('description', 'like', '%' . $keyword . '%');
                });
        }

        if ($avail) {
            $filter = $filter->where("availability", $avail);
        }

        $filterclone = clone $filter;
        $count = $filterclone->count();
        $active = $filterclone->where('availability', 1)->count();

        $products = $filter->paginate(30);
        return ['status' => "success", "message" => "Fetched succesfully", "data" => ["products" => $products, "count" => $count, "active" => $active]];
    }

    public function storeCommodity($admin, $commodity_name, $buy_price, $sell_price, $state_tax, $transportation, $warehousing, $other_cost, $availability, $description, $product_image, $quantity_in_stock, $duration, $total_purchase_price, $profit_margin, $minimum_quantity)
    {
        $commodity = $this->commodityRepo->create(["commodity_name" => $commodity_name, "buy_price" => $buy_price, "sell_price" => $sell_price, "state_tax" => $state_tax, "transportation" => $transportation, "warehousing" => $warehousing, "other_costs" => $other_cost, "availability" => $availability, "description" => $description, "product_image" => $product_image, "quantity_in_stock" => $quantity_in_stock, "total_in_store" => $quantity_in_stock, "duration" => $duration, "profit_margin" => $profit_margin, "purchase_price" => $total_purchase_price, "minimum_quantity" => $minimum_quantity]);

        if ($commodity) {
            //generate batch no
            $batchNo = $this->generateBatchNo($commodity);
            //enter the it into it batch and log current batch
            $this->commodityBatchRepo->create(["commodity_id" => $commodity->id, "batch_no" => $batchNo, "quantity_checked_in" => $quantity_in_stock, "in_stock" => $quantity_in_stock, "is_current" => 1]);
            //log batch
            $this->batchLog->create(["commodity_id" => $commodity->id, "batch_no" => $batchNo, "action_type" => 1, "quantity" => $quantity_in_stock, "in_stock" => $quantity_in_stock]);
            return ["status" => "success", "message" => "Commodity created succesfully"];
        } else {
            return ["status" => "error", "message" => "Unable to create product"];
        }
    }

    public function commodityDetails($admin, $product_id)
    {
        $product = $this->commodityRepo->whereId($product_id)->first();
        if ($product) {
            return ["status" => "success", "message" => "Fetched successfully", "product" => $product, "batches" => $product->batches];
        } else {
            return ["status" => "error", "message" => "unable to fetch details"];
        }
    }

    public function updateProduct($admin, $productId, $commodity_name, $buy_price, $sell_price, $state_tax, $transportation, $warehousing, $other_cost, $availability, $description, $quantity_in_stock, $duration, $total_purchase_price, $profit_margin, $commodity_image = null, $minimum_quantity)
    {
        $product = $this->commodityRepo->whereId($productId)->update(["commodity_name" => $commodity_name, "buy_price" => $buy_price, "sell_price" => $sell_price, "state_tax" => $state_tax, "transportation" => $transportation, "warehousing" => $warehousing, "other_costs" => $other_cost, "availability" => $availability, "description" => $description, "quantity_in_stock" => $quantity_in_stock, "profit_margin" => $profit_margin, "purchase_price" => $total_purchase_price, "product_image" => $commodity_image ?? $this->commodityRepo->whereId($productId)->first()->product_image, "duration" => $duration, "minimum_quantity" => $minimum_quantity]);


        $this->commodityBatchRepo->where('commodity_id',$productId)->where("is_current",1)->update( [ "in_stock" => $quantity_in_stock, "is_current" => 1]);
        //log batch
        $batch =  $this->commodityBatchRepo->where('commodity_id',$productId)->where("is_current",1)->first();
        if($batch)
        {
            $this->batchLog->where("commodity_id", $productId)->where("batch_no",$batch->batch_no)->update([  "in_stock" => $quantity_in_stock]);
        }
       

        

        if ($product) {
            return ["status" => "success", "message" => "updated successfully", "product" => $product];
        } else {
            return ["status" => "error", "message" => "unable to update"];
        }
    }
    private function generateBatchNo($commodity)
    {
        return "BAHRANDA11" . $commodity->id . ($this->commodityBatchRepo->where('commodity_id', $commodity->id)->count() + 1);
    }

    public function storeNewBatch($admin, $commodity, $quantity)
    {
        $batchNo = $this->generateBatchNo($commodity);
        //enter the it into it batch and log current batch
        $this->commodityBatchRepo->create(["commodity_id" => $commodity->id, "batch_no" => $batchNo, "quantity_checked_in" => $quantity, "in_stock" => $quantity, "is_current" => 0]);

        //update total commodity available
        $commodity->total_in_store = $commodity->total_in_store + $quantity;
        $commodity->save();
        //log batch
        $this->batchLog->create(["commodity_id" => $commodity->id, "batch_no" => $batchNo, "action_type" => 1, "quantity" => $quantity, "in_stock" => $quantity]);
        return ["status" => "success", "message" => "New batch added successfully", "batch_no" => $batchNo];
    }

    public function changeBatch($admin, $commodity, $batch_no)
    {
        $this->commodityBatchRepo->where(["commodity_id" => $commodity->id])->update(["is_current" => 0]);
        $this->commodityBatchRepo->where(["commodity_id" => $commodity->id])->where('batch_no', $batch_no)->update(["is_current" => 1]);
        return ["status" => "success", "message" => "Batch changed succesfully"];
    }

    public function batchHistory($admin, $batch_no)
    {
        $resp =  $this->batchLog->where('batch_no', $batch_no)->get();
        return $resp;
    }

    public function priceUploadBatches($admin, $keyword)
    {
        $filter = $this->batchPriceUploadRepo->newQuery();
        if ($keyword) {
            $filter = $filter->where('batch_no', $keyword);
        }
        $batches =  $filter->get();
        return ["status" => "success", "message" => "Price upload batches fetched succesfuly", "batches" => $batches];
    }

    public function priceUploadBatchData($admin, $batch_no)
    {
        //
        $batch_data = $this->batchPriceUploadDataRepo->where('batch_no', $batch_no)->get();
        return ["status" => "success", "message" => "Fetched successfully", "batch_data"  => $batch_data];
    }

    public function authorizePriceUpload($admin, $batch_no, $type)
    {
        $price_upload = $this->batchPriceUploadRepo->where('batch_no', $batch_no)->first();
        if ($type == 1) {
            //authorize
            $price_upload->status = 1;
            $price_upload->save();
            //upload price
            $this->uploadPrice($batch_no);
            return ["status" => "success", "message" => "Price upload authorised successfully"];
        } else {
            $price_upload->status = 2;
            $price_upload->save();
            return ["status" => "success", "message" => "Price upload declined successfully"];
        }
    }

    private function uploadPrice($batch_no)
    {
        $batch_data =  $this->batchPriceUploadDataRepo->where('batch_no', $batch_no)->get();
        foreach ($batch_data as $data) {
            $this->commodityRepo->where('id', $data->commodity_id)->update(["commodity_name" => $data->commodity_name, "buy_price" => $data->buy_price, "warehousing" => $data->warehousing, "other_costs" => $data->other_costs, "transportation" => $data->transportation, "profit_margin" => $data->profit_margin, "purchase_price" => $data->total_purchase_price, "sell_price" => $data->target_sale_price, "state_tax" => $data->state_tax]);
        }
    }

    public function deleteCommodity($admin, $product_id)
    {
        $product = $this->commodityRepo->whereId($product_id)->delete();

        if ($product) {
            return ["status" => "success", "message" => "deleted successfully"];
        } else {
            return ["status" => "error", "message" => "unable to update"];
        }
    }

     public function purchaseFromUserWallet($userId, $commodityId, $quantity)
    {
        //calculate the amount it is supposed to pay
        $user = User::where('id',$userId)->first();
        if(!$user ) {
              return ["status" => "error", "message" => "user not found"];
        }
        $check = $this->commodityRepo->where('availability',1)->where('id', $commodityId)->exists();

        if ($check) {
            $commodity = $this->commodityRepo->where('availability',1)->where('id', $commodityId)->first();

            if ($commodity->currentBatch->in_stock < $quantity) {
              if(!$user ) {
              return ["status" => "error", "message" => "commodity is not available"];
              }
            }
            $deal_amount = $commodity->getPriceBreakDown($quantity)['total_deal_cost'];

            if ($quantity < $commodity->minimum_quantity) {

                return ["status" => "error", "message" => "Minimum quantity purchaseable for this commodity is " . $commodity->minimum_quantity, 400];
              }
            }else {
                return ["status" => "error", "message" =>  "Commodity is not available for deal"];
            }


            $expected_return = $commodity->getPriceBreakDown($quantity)['expected_return'];
          
            //check user has enough balance
            $wallet = $this->walletRepo->where('user_id',$user->id)->first();

            if(!$wallet)
            {
                 return ["status" => "error", "message" => "unable to debit wallet"];
            }

            $checkBalance = $wallet->balance > $deal_amount;

            $reference = Str::random(25);
             
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

                  return ['status' => "success", "message" => "Deal purchased successfully"];
            }else{
                 return ["status" => "error", "message" => "User does not have enough balance"];
            }
    }

     private function updateCommodityAvailability($commodityId, $quantity)
    {
        $commodity = $this->commodityRepo->where('id', $commodityId)->first();

        if ($commodity->currentBatch->in_stock < $quantity) {
            $commodity->availability = 0;
            $commodity->save();
        }
    }
}
