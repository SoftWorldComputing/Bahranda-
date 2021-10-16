<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            "warehouse_name" => $this->warehouse_name,
            "warehouse_image" => asset($this->warehouse_image),
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "contact_person" => $this->contact_person,
            "contact_person_phone" => $this->contact_person_phone
        ];
    }
}
