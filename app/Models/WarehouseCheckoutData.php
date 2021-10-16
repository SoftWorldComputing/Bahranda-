<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseCheckoutData extends Model
{
    //
    protected $guarded = [];

    public function commodity()
    {
        return $this->hasOne('App\Models\Commodity', 'id', 'commodity_id')->withTrashed();
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
}
