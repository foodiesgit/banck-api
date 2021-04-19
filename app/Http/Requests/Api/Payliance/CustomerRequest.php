<?php

namespace App\Http\Requests\Api\Payliance;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'required',
            'street_address1' => 'required',
            'city' => 'required',
            'state_code' => 'required',
            'zip_code' => 'required',
        ];
    }
}
