<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewAdminRequest extends FormRequest
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
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'phone' => 'required|min:11|max:15',
                'sex' => 'required|integer',
                'role' => 'required|integer',
                'email' => 'required|email|unique:admins',
                
        ];
    }


    protected function getRedirectUrl()
    {
        flash('Error! please check inputs and try again')->error();
       
    }
}
