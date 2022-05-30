<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommoditiesResource extends JsonResource
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
            "commodity_name" => ucwords($this->commodity_name),
            "description" => ($this->description),
            "price" => ($this->purchase_price),
            "unit" => "Per bag/truck",
            "duration" => ceil($this->duration) . " Months",
            "profit_percentage" => $this->profit_margin . "%",
            "image" => asset('storage/' . $this->product_image),
            "availability" => $this->availability
        ];
    }
}
