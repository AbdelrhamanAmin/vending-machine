<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->user()->role === User::SELLER_ROLE;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name'=>  [ 'string', 'required' ],
            'amount_available'=> [ 'numeric', 'required' ],
            'cost'=> [ 'numeric', 'required' ],
        ];
    }
}
