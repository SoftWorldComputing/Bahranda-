<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseCommodity extends Model
{
    //
    protected $guarded = [];

    public function commodity()
    {
        return $this->hasOne('App\Models\Commodity', 'id', 'commodity_id')->withTrashed();
    }
}
