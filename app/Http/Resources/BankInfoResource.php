<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankInfoResource extends JsonResource
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
            "account_name" => $this->account_name ?? "",
            "bank_name" => $this->bank_name ?? "",
            "account_no" => $this->account_no ?? "",
        ];
    }
}
