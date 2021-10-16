<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchPriceUploadData extends Model
{
    //
    protected $guarded = [];

    public function commodity()
    {
        return $this->belongsTo('App\Models\Commodity', 'commodity_id', 'id')->withTrashed();
    }
}
