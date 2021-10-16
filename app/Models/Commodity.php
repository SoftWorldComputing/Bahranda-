<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Commodity extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];

     use UsesUuid; 


    public function currentBatch()
    {
        return $this->hasOne(CommodityBatch::class,'commodity_id','id')->where('is_current',1);
    }

    public function batches()
    {
        // return $this->hasMany(CommodityBatch::class,'commodity_id','id')->where('is_current',0);

         return $this->hasMany(CommodityBatch::class,'commodity_id','id');
    }

    public function  getPriceBreakDown($quantity)
    {
        $transportation = $this->transportation  * $quantity;
        $state_tax = ($this->state_tax * 0.01) * ($this->buy_price * $quantity);
        $warehousing = ($this->warehousing * $quantity);
        $other_costs = ($this->other_costs * $quantity);
        $total_deal_cost = ($this->purchase_price  * $quantity);
        $gain = ( $total_deal_cost  * ($this->profit_margin / 100));
        $expected_return =  $total_deal_cost +  $gain ;
        return [
            "commodity_cost" => $this->buy_price * $quantity,
            "state_tax" => $state_tax,
            "transportation" => $transportation,
            "warehousing" => $warehousing,
            "other_costs" => $other_costs,
            "total_deal_cost" => $total_deal_cost ,
            "expected_return" =>  $expected_return
        ];
    }
    
    public function warehouses()
    {
        return $this->belongsToMany('App\Models\Warehouse', 'warehouse_commodities', 'commodity_id','warehouse_id')->withPivot('quantity_in_store');
    }
}
