<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //
    protected $guarded = [];

  
    public function commodities()
    {
        return $this->belongsToMany('App\Models\Commodity', 'warehouse_commodities', 'warehouse_id','commodity_id')->withPivot('quantity_in_store');
    }

    public function activity()
    {
        return $this->hasMany('App\Models\WarehouseLog', 'warehouse_id','id');
    }
}
