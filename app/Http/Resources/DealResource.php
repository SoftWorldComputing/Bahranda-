<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "commodity" => [
                "commodity_name" => $this->commodity->commodity_name,
                "descriptiion" => $this->commodity->description,
            ],
             "duration" => ceil($this->duration)." Months",
             "status" => $this->getStatus(),
             "deal_start_date" => Carbon::parse($this->created_at)->format("Y-m-d H:m:i"),
             "deal_end_date" => Carbon::now()->addMonths(ceil($this->duration))->format("Y-m-d 23:59:59"),
             "quantity" => $this->quantity,
        ];
    }
}
