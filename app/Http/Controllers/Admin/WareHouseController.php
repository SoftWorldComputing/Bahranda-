<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Classes\WareHouseMgtClass;
use App\Models\Warehouse;
class WareHouseController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:admin','warehousemgt']);
        $this->warehouseMgtClass = new WareHouseMgtClass;
    }

    public function ListWarehouses(Request $request)
    {
            $resp = $this->warehouseMgtClass->getAllWareHouse($request->keyword);
            return view('dashboard.warehouses.list_warehouses',$resp);
    }

    public function AddWarehouseView(Request $request)
    {
        $resp = $this->warehouseMgtClass->getAllCommodities();
        return view('dashboard.warehouses.add_warehouse',["commodities" => $resp]);

    }

    public function StoreWarehouse(Request $request)
    {
        //upload image

        $warehouse_image = $request->file('warehouse_image')->store('images');
        $resp = $this->warehouseMgtClass->storeWarehouse($this->admin,$request->warehouse_name,$warehouse_image,$request->address,$request->city,$request->state,$request->contact_person_name,$request->contact_person_phone,$request->commodities ?? [],$request->quantity_in_store);


        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }

    public function ShowWarehouse(Request $request,Warehouse $warehouse)
    {
        return view('dashboard.warehouses.show_warehouse',['warehouse' => $warehouse]);

    }

    public function CheckoutRequestView(Request $request,Warehouse $warehouse)
    {
        return view('dashboard.warehouses.checkout_warehouse',['warehouse' => $warehouse]);

    }

    public function WarehouseCheckoutRequest(Request $request)
    {
        $batches = $this->warehouseMgtClass->getWarehouseCheckoutRequest();
        return view('dashboard.warehouses.warehouse_checkout_request',['batches' => $batches]);

    }

    public function WarehouseCheckoutRequestData(Request $request)
    {
      
        $batch_data = $this->warehouseMgtClass->getWarehouseCheckoutRequestData($request->batch_no);
        return view('dashboard.warehouses.warehouse_checkout_request_data',['batch_data' => $batch_data,"batch_no" => $request->batch_no]);

    }

    public function WareHouseCheckoutRequestSubmit(Request $request,Warehouse $warehouse)
    {
         $resp = $this->warehouseMgtClass->submitCheckoutRequest($this->admin,$warehouse,$request->commodities,$request->quantity_to_checkout);

         if($resp && $resp['status'] == "success")
         {
             flash($resp['message'])->success();
         }else{
        
             flash($resp['message'])->error();
 
         }
         return redirect()->back();
    }

    public function AuthorizeWarehouseCheckout(Request $request)
    {
        $resp = $this->warehouseMgtClass->authorizeCheckout($this->admin,$request->batch_no,$request->type);
        return $resp;
    }
}
