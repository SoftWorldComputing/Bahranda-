<?php
namespace App\Classes;
use App\Models\Warehouse;
use App\Models\WarehouseLog;
use App\Models\Commodity;
use App\Models\WarehouseCommodity;
use App\Models\WarehouseCheckout;
use App\Models\WarehouseCheckoutData;

class WareHouseMgtClass {

    public function __construct()
    {
        $this->warehouseRepo = new Warehouse;
        $this->commodityRepo = new Commodity;
        $this->warehouseLogRepo = new WarehouseLog;
        $this->warehouseCommodity = new WarehouseCommodity;
        $this->warehouseCheckout = new WarehouseCheckout;
        $this->warehouseCheckoutData = new WarehouseCheckoutData;
    }

    public function getAllCommodities()
    {
        return $this->commodityRepo->all();
    }
    public function storeWarehouse($admin,$warehouse_name,$warehouse_image,$address,$city,$state,$contact_person,$contact_person_phone,$warehouse_commodities,$commodities_in_store)
    {
     
        $warehouse =  $this->warehouseRepo->create(["warehouse_name" => $warehouse_name,"address" => $address,"city" => $city,"state" => $state,"contact_person" => $contact_person,"contact_person_phone" => $contact_person_phone,"warehouse_image" => $warehouse_image]);

        if($warehouse){
            //warehouse created and log
            $commodity_and_quantities = [];
            $index = 0;
            
            if(!empty($warehouse_commodities)) {
                foreach($warehouse_commodities as $commodity_id){ 
                            if(is_null($commodity_id))
                            {
                                continue;
                            }
                            $commodity_and_quantity = ["warehouse_id" => $warehouse->id,"commodity_id" => $commodity_id,"quantity_in_store" => $commodities_in_store[$index]];
                            array_push($commodity_and_quantities,$commodity_and_quantity);
                            $index++;
                }

                WarehouseCommodity::insert($commodity_and_quantities);
            }
           $warehouse_log =  $this->warehouseLogRepo->create(["admin_id" => $admin->id,"warehouse_id" => $warehouse->id,"admin_name" => $admin->name,"activity" => "Added ".$warehouse_name." as a new warehouse at " . $city.",".$state]);
           return ["status" => "success","message" => "Warehouse created successfully"];

        }else{
           return ["status" => "error","message" => "Unable to create warehouse"];

        }
    }

    public function getAllWareHouse($keyword)
    {
        $filter = $this->warehouseRepo->newQuery();
        if($keyword)
        {
            $filter->where('warehouse_name','like','%'.$keyword.'%');
        }
        $warehouses = $filter->paginate(30);
        return  ["status" => "success","message" => "Fetched successsuflly","warehouses" =>  $warehouses];
    }

    public function submitCheckoutRequest($admin,$warehouse,$commodities,$quantity_to_checkout)
    {
        //checkout 
        $rep = $this->confirmQuantityIsCorrect($commodities,$warehouse,$quantity_to_checkout);
        if(!$rep['confirmed'])
        {
            return ["status" => "error","message" => $rep['errorbag']];
        }
        //save it 
        $batch_no = $this->generateCheckoutBatchNo();
        //preapre insert
        $this->warehouseCheckout->create(["batch_no" => $batch_no,"warehouse_id" => $warehouse->id]);
        $index = 0;
        $insertArray = [];
        foreach ($commodities as $commodity) {
            $cmd =  $this->warehouseCommodity->where('warehouse_id',$warehouse->id)->where('commodity_id',$commodity)->first();
            array_push($insertArray,["batch_no" => $batch_no,"commodity_id" => $commodity,"warehouse_id" => $warehouse->id,"quantity_to_checkout" => $quantity_to_checkout[$index],"amount_left_in_store" => ($cmd->quantity_in_store -  $quantity_to_checkout[$index]) ]);
            $index++;
        }
        $this->warehouseCheckoutData->insert($insertArray);
        return ["status" => "success","message" => "Checkout request submitted succesfully"];
    }

    //confirm quantity is correct
    private function confirmQuantityIsCorrect($commodities,$warehouse,$quantity_to_checkout)
    {
        $confirmed = true;
        $index = 0;
        $errorbag = '';
        foreach ($commodities as $commodity) {
            # code...
            $cmd =  $this->warehouseCommodity->where('warehouse_id',$warehouse->id)->where('commodity_id',$commodity)->first();
            if($quantity_to_checkout[$index] > $cmd->quantity_in_store)
            {
                $confirmed = false;
                $errorbag =   $errorbag.$cmd->commodity->commodity_name. " is more than avaiable in this warehouse \n" ;
            }
      
            $index++;
        }

        return ["confirmed" => $confirmed,"errorbag" => $errorbag];
    }

    private function generateCheckoutBatchNo()
    {
        return "CHECKOUTXXX".(WarehouseCheckout::count() + 1);
    }

    public function getWarehouseCheckoutRequest()
    {
        return  $this->warehouseCheckout->all();
    }

    public function getWarehouseCheckoutRequestData($batch_no)
    {
        return $this->warehouseCheckoutData->where('batch_no',$batch_no)->get();
    }

    //authorize 
    public function authorizeCheckout($admin,$batch_no,$type)
    {
        $warehouse_checkout = $this->warehouseCheckout->where('batch_no',$batch_no)->first();
        if($type == 1)
        {
            //authorize
            $warehouse_checkout->status = 1;
            $warehouse_checkout->save();
            //upload price
            $this->processcheckout($batch_no);
            return ["status" => "success","message" => "Checkout authorised successfully"];

        }else{
            $warehouse_checkout->status = 2;
            $warehouse_checkout->save();
            return ["status" => "success","message" => "Checkout declined successfully"];
        }
    }

    private function processcheckout($batch_no)
    {
        $batch_data =  $this->warehouseCheckoutData->where('batch_no',$batch_no)->get();
        foreach ($batch_data as $data) {
            $warehouseCom =  $this->warehouseCommodity->where('warehouse_id',$data->warehouse_id)->where('commodity_id',$data->commodity_id)->first();
            $warehouseCom->quantity_in_store  = $warehouseCom->quantity_in_store - $data->quantity_to_checkout; 
            $warehouseCom->save();
        }
    }

}