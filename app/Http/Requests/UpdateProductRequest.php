<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Services\ProductService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{

    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth()->user()->role === User::SELLER_ROLE );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name'=>  ['string'],
            'amount_available'=> [ 'numeric'],
            'cost'=> [ 'numeric'],
        ];
    }
}
