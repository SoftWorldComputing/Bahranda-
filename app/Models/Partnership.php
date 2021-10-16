<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    //
    protected $guarded = [];
    use UsesUuid;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'commodity_id', 'id')->withTrashed();
    }

    public function partnership_br()
    {
        return $this->hasOne(PartnershipBreakdown::class, 'partnership_id', 'id');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 1:
                return "on-going";
                break;
            case 2:
                return "cancelled";
                break;
            case 3:
                return "completed";
                break;
            case 4:
                return "closed";
                break;
            default:
                return "Unknown";
        }
    }

    public function getTimeLeftAttribute()
    {
        $today = Carbon::now();
        $enddate = $this->created_at->addMonths($this->duration);
        return $enddate;
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }

    public function  getPriceBreakDown()
    {
        return [
            "commodity_cost" => $this->partnership_br->buy_price * $this->quantity,
            "state_tax" => ($this->partnership_br->state_tax * 0.01 * $this->partnership_br->buy_price * $this->quantity),
            "transportation" => $this->partnership_br->transportation * $this->quantity,
            "warehousing" => $this->partnership_br->warehousing * $this->quantity,
            "other_costs" => $this->partnership_br->other_costs * $this->quantity,

        ];
    }
}
