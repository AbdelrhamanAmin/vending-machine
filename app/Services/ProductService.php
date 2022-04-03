<?php

namespace App\Services;

use App\Models\Product;


class ProductService {

    /**
     * create function
     *
     * @param [type] $product
     * @return Product
     */
    public function create($product) {
        return Product::create([
            'product_name'=> $product->product_name,
            'amount_available'=> $product->amount_available,
            'cost'=> $product->cost,
            'seller_id'=> Auth()->user()->id,
        ]);
    }

    /**
     * list function
     *
     * @return Product
     */
    public function list() {
        return Product::with(["seller" => function($query){
            $query->select('id','username');
            }])->get();
    }

    /**
     * authorizeProduct function
     * check if logged in user  owns product
     * @param [type] $productId
     * @return boolean
     */
    public function authorizeProduct($productId)
    {
        return Product::where('id', $productId)->where('seller_id', Auth()->user()->id)->exists();
    }
}
