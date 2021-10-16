<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommodityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'commodity_name' => 'required|max:255',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'state_tax' => 'required|numeric',
            'transportation' => 'required|numeric',
            'warehousing' => 'required|numeric',
            'other_cost' => 'required|numeric',
            'quantity_in_stock' => 'required|numeric',
            'availability' => 'required',
            'description' => 'required|max:200',
            'commodity_image' => 'required|image|max:2048',
            'duration' => 'required|numeric',
            'total_purchase_price' => 'required|numeric',
            'profit_percentage' => 'required|numeric',
            'minimum_quantity' => 'required|numeric'
        ];
    }
    protected function getRedirectUrl()
    {
        flash('Error! please check inputs and try again')->error();
    }
}
