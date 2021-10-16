<?php

namespace App\Classes;

use App\Mail\DealStatusChangeMail;
use App\Models\Partnership;
use App\Models\Warehouse;
use App\Models\WarehouseCommodity;
use Illuminate\Support\Facades\Mail;

class PartnershipMgtClass
{

    public function __construct()
    {
        $this->partnershipRepo = new Partnership;
        $this->warehouseRepo = new Warehouse;
        $this->warehouseCommodityRepo = new WarehouseCommodity;
    }

    public function getAllPartnerships($admin, $keyword = null)
    {
        $partnerships = $this->partnershipRepo->orderBy('id', 'desc')->paginate(30);
        $active_partnerships = $this->partnershipRepo->where('status', 1)->count();
        $completed_partnerships = $this->partnershipRepo->where('status', 3)->count();
        $cancelled_partnerships = $this->partnershipRepo->where('status', 2)->count();
        $closed_partnerships = $this->partnershipRepo->where('status', 4)->count();
        return ["status" => "success", "message" => "fetched successfully", "partnerships" => ['partnerships' => $partnerships, 'active_partnerships' => $active_partnerships, 'completed_partnerships' => $completed_partnerships, 'cancelled_partnerships' => $cancelled_partnerships, 'closed_partnerships' =>  $closed_partnerships]];
    }

    public function getPartnerShipDetails($admin, $partnership)
    {
        // dd($partnership->partnership_br);
        return ['partnership' => $partnership, 'warehouses' => $this->warehouseRepo->all()];
    }

    public function  assignWarehouse($admin, $partnership, $warehouse)
    {
        $partnership->warehouse_id = $warehouse;
        $partnership->save();
        //check commodity is in warehouse if true add to it,
        $warehouseCommodity = $this->warehouseCommodityRepo->where('warehouse_id', $warehouse)->where('commodity_id', $partnership->commodity_id)->first();
        if ($warehouseCommodity) {
            $warehouseCommodity->quantity_in_store = $warehouseCommodity->quantity_in_store + $partnership->quantity;
            $warehouseCommodity->save();
        } else {
            $this->warehouseCommodityRepo->create([
                "warehouse_id" => $warehouse,
                "commodity_id" => $partnership->commodity_id,
                "quantity_in_store" => $partnership->quantity,
            ]);
        }
        //if not add commodity to warehouse and increase it quantity
        return ["status" => "success", "message" => "Warehouse assigned successfully"];
    }

    public function changePartnershipStatus($admin, $partnership, $status)
    {
        if ($status == 4 && $partnership->real_amount_sold <= 0) {
            //check  real amount sol is greater than zero   
            return ["status" => "error", "message" => "Deal cannot be closed before real price sold is entered"];
        }
        $partnership->status = $status;
        //when deal is closed
        if ($status == 4) {
            $deal = $partnership->partnership_br->sell_price * $partnership->quantity;
            $user = $partnership->user;
            $expected_return = $partnership->expected_return;
            $user->walletHistory()->create([
                "user_id" => $user->id,
                "remark" =>  "₦" . number_format($expected_return) . " has been paid into your account as your return on " . strtolower($partnership->commodity->commodity_name) . " deal",
                "status" => "credit",
                "amount" => $deal
            ]);

            // store transactions

            $user->wallet->balance = $user->wallet->balance + $expected_return;
            $user->wallet->save();
            try {

                $status = $this->resolvePartnershipText($status);

                Mail::to($user->email)->send(new DealStatusChangeMail($user, $partnership, $status));
            } catch (\Exception $e) {
            }
        }
        $partnership->save();
        return ["status" => "success", "message" => "Partner status updated successfully"];
    }

    public function getDealsByBatch()
    {

        return $this->partnershipRepo->get()->groupBy('batch_no');
    }

    public function getDealsOfBatch($batch_no)
    {
        //
        $partnerships = $this->partnershipRepo->where('batch_no', $batch_no)->get();
        return ["status" => "success", "message" => "fetched successfully", "partnerships" => $partnerships, "warehouses" => $this->warehouseRepo->get()];
    }

    public function batchUpdateDeals($admin, $deals = [], $type, $warehouse = null, $status = null)
    {
        $resp = ["status" => "error", "message" => "unknown"];

        if (is_null($deals)) {
            return $resp;
        }
        if ($type == "deal_to_warehouse") {
            //update deal to warehouse
            $resp = $this->updateDealsWarehouse($deals, $warehouse);
        }

        if ($type == "deal_status_change") {
            //update deal to warehouse
            $resp = $this->updateDealStatus($deals, $status);
        }
        return $resp;
    }

    private function updateDealsWarehouse($deals, $warehouse)
    {
        foreach ($deals as $deal) {
            $thedeal = $this->partnershipRepo->whereId($deal)->first();
            $thedeal->warehouse_id = $warehouse;
            $thedeal->save();
            $commodity = $thedeal->commodity;

            //update the quanity
            $warehousecommodity =  $this->warehouseCommodityRepo->where('commodity_id', $commodity->id)->where('warehouse_id', $warehouse)->first();
            if ($warehousecommodity) {
                $warehousecommodity->quantity_in_store = $warehousecommodity->quantity_in_store + $thedeal->quantity;
                $warehousecommodity->save();
            }
        }
        return ["status" => "success", "message" => "Warehouse updated successfully"];
    }

    private function updateDealStatus($deals, $status)
    {
        $this->partnershipRepo->whereIn('id', $deals)->update(['status' => $status]);
        return ["status" => "success", "message" => "Deals updated successfully"];
    }

    public function  updatePriceSold($admin, $amount, $partnership)
    {
        $partnership->real_amount_sold = $amount;
        $partnership->profit =  (($partnership->real_amount_sold * $partnership->quantity)  - ($partnership->partnership_br->sell_price *  $partnership->quantity));
        $partnership->save();
        return ["status" => "success", "message" => "Real price updated successfully"];
    }

    public function getUserPartnership($user)
    {
        $partnerships = $this->partnershipRepo->where('user_id', $user)->orderBy('id', 'desc')->get();
        return $partnerships;
    }

    private function resolvePartnershipText($status)
    {
        switch ($status) {
            case 1:
                return "On-going";
                break;

            case 2:
                return "Cancelled";
                break;

            case 3:
                return "Completed";
                break;
            case 4:
                return "Closed";
                break;

            default:
                return "Unknown";
                break;
        }
    }
}
