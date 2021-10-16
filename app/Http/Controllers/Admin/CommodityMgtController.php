<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Classes\CommodityMgtClass;
use App\Classes\UserCommodityClass;
use App\Classes\UserMgtClass;
use App\Classes\UserWalletClass;
use App\Http\Requests\StoreCommodityRequest;
use App\Exports\CommodityPriceExport;
use App\Http\Requests\AdminPurchaseCommodityRequest;
use App\Imports\CommodityImport;
use App\Models\Commodity;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class CommodityMgtController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(["auth:admin", "commoditymgt"]);
        $this->commodityMgtClass = new CommodityMgtClass;
        $this->userMgtClass = new UserMgtClass;
        $this->userWalletClass = new UserWalletClass;
        $this->userCommodityClass = new UserCommodityClass;
    }

    public function CommodityList(Request $request)
    {
        $resp = $this->commodityMgtClass->listCommodities($request->keyword, $request->availability);
        return view('dashboard.commodity.list_commodities', $resp);
    }

    public function StoreCommodityView(Request $request)
    {
        return view('dashboard.commodity.add_commodity');
    }
    // public function StoreCommodity(StoreCommodityRequest $request)

    public function StoreCommodity(StoreCommodityRequest $request)
    {

        $commodity_image = $request->file('commodity_image')->store('images');
        $resp = $this->commodityMgtClass->storeCommodity($this->admin, $request->commodity_name, $request->buy_price, $request->sell_price, $request->state_tax, $request->transportation, $request->warehousing, $request->other_cost, $request->availability, $request->description, $commodity_image, $request->quantity_in_stock, $request->duration, $request->total_purchase_price, $request->profit_percentage, $request->minimum_quantity);

        return $resp;
    }

    public function CommodityShow(Request $request)
    {
        //show product
        $resp = $this->commodityMgtClass->commodityDetails($this->admin, $request->product);
        if ($resp && $resp['status'] == "success") {
            return view('dashboard.commodity.view_commodities', ["product" => $resp["product"], "batches" => $resp["batches"]]);
        } else {
            abort(404);
        }
    }

    public function CommodityEditView(Request $request)
    {
        $resp = $this->commodityMgtClass->commodityDetails($this->admin, $request->product);
        if ($resp && $resp['status'] == "success") {
            $resp['product']->product_image = asset('storage/' . $resp['product']->product_image);
            return view('dashboard.commodity.commodity_edit', ["product" => $resp["product"]]);
        } else {
            abort(404);
        }
    }

     public function PurchaseCommodityView(Request $request,Commodity $commodity)
    {
            $users = $this->userMgtClass->getUsers();
            return view('dashboard.commodity.purchase_for_user',['commodity' => $commodity,"users" => $users]);
    }

    public function FetchUserBalance(Request $request,User $user)
    {
        //get user balance
        $wallet = $this->userWalletClass->getUserWallet($user);

        return $wallet;
    }

    public function FetchCommodityPrice(Request $request)
    {
       $resp =   $this->userCommodityClass->calculateCommodityPrice($request->commodity,$request->quantity);

       return  $resp;
    }

      public function PurchaseCommodity(AdminPurchaseCommodityRequest $request)
    {
       $resp =   $this->commodityMgtClass->purchaseFromUserWallet($request->user,$request->commodity_id,$request->quantity);

       if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }

    public function CommodityEdit(Request $request)
    {
        if ($request->has('commodity_image')) {
            $commodity_image = $request->file('commodity_image')->store('images');
        } else {
            $commodity_image = null;
        }
        $resp = $this->commodityMgtClass->updateProduct($this->admin, $request->product, $request->commodity_name, $request->buy_price, $request->sell_price, $request->state_tax, $request->transportation, $request->warehousing, $request->other_cost, $request->availability, $request->description, $request->quantity_in_stock, $request->duration, $request->total_purchase_price, $request->profit_percentage, $commodity_image, $request->minimum_quantity);
        return $resp;
    }

    public function CommodityPriceList(Request $request)
    {

        $resp = $this->commodityMgtClass->listCommodities($request->keyword, $request->availability);
        return view('dashboard.commodity.commodity_prices', $resp);
    }

    public function CommodityPriceUpdateView(Request $request)
    {
        return view('dashboard.commodity.update_commodity_prices');
    }

    public function CommodityTemplate(Request $request)
    {
        return Excel::download(new CommodityPriceExport, 'commodity_format.xlsx');
    }

    public function CommodityPriceUpdate(Request $request)
    {
        $commodity_file = $request->file('commodity_prices')->store('images');
        Excel::import(new CommodityImport, $commodity_file);
        flash("Price uploaded succesfully")->success();
        return redirect()->back();
    }

    public function  StoreNewBatch(Request $request, Commodity $commodity)
    {
        $resp = $this->commodityMgtClass->storeNewBatch($this->admin, $commodity, $request->quantity);
        return $resp;
    }

    public function  ChangeBatch(Request $request, Commodity $commodity)
    {
        $resp = $this->commodityMgtClass->changeBatch($this->admin, $commodity, $request->batch_no);
        return $resp;
    }

    public function BatchHistory(Request $request, Commodity $commodity)
    {
        $resp = $this->commodityMgtClass->batchHistory($this->admin, $request->batch);
        return view('dashboard.commodity.batch_history', ['batch_logs' => $resp, "batch_no" => $request->batch, "commodity" => $commodity]);
    }

    public function PriceUploadBatchView(Request $request)
    {
        $resp = $this->commodityMgtClass->priceUploadBatches($this->admin, $request->keyword);
        return view('dashboard.commodity.price_upload_batch', ['batches' => $resp["batches"]]);
    }

    public function PriceUploadBatchDataView(Request $request)
    {
        $resp = $this->commodityMgtClass->priceUploadBatchData($request->admin, $request->batch_no);
        return view('dashboard.commodity.price_upload_batch_data', ["batch_no" => $request->batch_no, "batch_data" => $resp['batch_data']]);
    }

    public function AuthorizePriceUpload(Request $request)
    {
        // use batchno
        $resp = $this->commodityMgtClass->authorizePriceUpload($this->admin, $request->batch_no, $request->type);
        return $resp;
    }

    public function  deleteCommodity(Request $request)
    {
        $resp = $this->commodityMgtClass->deleteCommodity($this->admin, $request->commodity);
        flash("Commodity deleted succesfully")->success();
        return redirect()->route('admin.productmgt.list');
    }
}
