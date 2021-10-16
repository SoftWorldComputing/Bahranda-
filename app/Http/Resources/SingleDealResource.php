<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class SingleDealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "commodity" => [
                "commodity_name" => $this->commodity->commodity_name,
                "descriptiion" => $this->commodity->description,
                "commodity_image" => asset('storage/' . $this->commodity->product_image)
            ],
            "duration" => ceil($this->duration) . " Months",
            "status" => $this->getStatus(),
            "deal_start_date" => Carbon::parse($this->created_at)->format("Y-m-d H:m:i"),
            "deal_end_date" => Carbon::now()->addMonths(ceil($this->duration))->format("Y-m-d 23:59:59"),
            "quantity" => $this->quantity,
            "total_amount_invested" => $this->amount,
            "expected_return" => $this->expected_return,
            "warehouse" => $this->when($this->warehouse, function () {
                return new WarehouseResource($this->warehouse);
            }, new stdClass),
            "profit" => $this->expected_return - $this->amount,
            "price_break_down" => $this->getPriceBreakDown($this->quantity)
        ];
    }
}
