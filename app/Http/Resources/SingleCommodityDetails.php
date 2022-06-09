<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleCommodityDetails extends JsonResource
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
            "commodity_name" => ucwords($this->commodity_name),
            "description" => ($this->description),
            "price" => ($this->purchase_price),
            "unit" => "per ",
            "duration" => ceil($this->duration) . " Months",
            "profit_percentage" => $this->profit_margin . "%",
            "image" => asset('storage/' . $this->product_image),
            "quantity_left_for_deal" => $this->currentBatch->in_stock,
            "price_break_down" => $this->getPriceBreakDown(1),
            "user_quantity" => 1,
            "availability" => $this->availability,
            "minimum_quantity" => $this->minimum_quantity,

        ];
    }
}
