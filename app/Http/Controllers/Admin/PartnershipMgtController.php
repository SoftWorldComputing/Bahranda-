<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Classes\PartnershipMgtClass;
use App\Models\Partnership;
class PartnershipMgtController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:admin','dealmgt']);
        $this->partnershipMgtClass = new PartnershipMgtClass;
    }

    public function AllPartnership(Request $request)
    {
        $partnerships = $this->partnershipMgtClass->getAllPartnerships($this->admin,$request->keyword);
        return view('dashboard.partnership.all_partnership',$partnerships['partnerships']);
    }

    public function ViewPartnerShip(Request $request,Partnership $partnership)
    {
        $parnership_details = $this->partnershipMgtClass->getPartnershipDetails($this->admin,$partnership);
        return view('dashboard.partnership.view_partnerships',$parnership_details);
    }

    public function AssignWarehouse(Request $request,Partnership $partnership)
    {

        $resp = $this->partnershipMgtClass->assignWarehouse($this->admin,$partnership,$request->warehouse);
        return $resp;
    }

    public function ChangePartnershipStatus(Request $request,Partnership $partnership)
    {
        $resp = $this->partnershipMgtClass->changePartnershipStatus($this->admin,$partnership,$request->status);
        return $resp;
    }

    public function DealByBatch(Request $request)
    {
        $resp = $this->partnershipMgtClass->getDealsByBatch();
        return view('dashboard.partnership.deal_by_batch',["partnerships" => $resp]);
    }

    public function BatchDealsView(Request $request)
    {
        $resp = $this->partnershipMgtClass->getDealsOfBatch($request->batch_no);
        return view('dashboard.partnership.deals_of_batches',['partnerships' => $resp['partnerships'],"warehouses" => $resp['warehouses'],"batch_no" => $request->batch_no]);
    }

    public function BatchUpdateDeals(Request $request)
    {
        $resp = $this->partnershipMgtClass->batchUpdateDeals($this->admin,$request->deals,$request->type,$request->warehouse,$request->status);
        return $resp;
    }

    public function UpdatePriceSold(Request $request,Partnership $partnership)
    {
        $resp = $this->partnershipMgtClass->updatePriceSold($this->admin,$request->real_amount,$partnership);
        return $resp;
    }

  
}
