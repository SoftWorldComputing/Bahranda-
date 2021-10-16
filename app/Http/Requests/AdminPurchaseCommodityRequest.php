<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminPurchaseCommodityRequest extends FormRequest
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
    
             "commodity_id" => "required",
             "user" => "required",
             "quantity" => "required|numeric"
        ];
    }

    protected function failedValidation(Validator $validator)
    {

         flash('Error! please check inputs and try again')->error();
    }
}
