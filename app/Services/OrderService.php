<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;


class OrderService {

    public function create($productId, $qty)
    {
        $user = User::find(Auth()->user()->id);
        $product = Product::find($productId);
        if( $product == null){
            throw new \Exception("Product Not Found", 404);
        }
        $totalOrderPrice = ($product->cost * $qty);
        if($this->validateOrderQty($product->amount_available, $qty)){throw new \Exception("Product out of stock");}
        if($this->validateUserCredit($user->deposit, $totalOrderPrice)){throw new \Exception("No enough credit");}
        try {
            $updatedProductAmount = $this->updatedProductAmount($product->amount_available, $qty);
            $updatedUserCredit = $this->updatedUserCredit($user->deposit, $totalOrderPrice);
            $product->update(['amount_available' => $updatedProductAmount]);
            $user->update(['deposit' => $updatedUserCredit]);
            return $this->formatOrderResponse($product->product_name, $totalOrderPrice, $updatedUserCredit);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function validateOrderQty($availableQty, $orderQty){
        return ($availableQty < $orderQty);
    }

    private function validateUserCredit($userCredit, $totalOrderPrice){
        return ($userCredit < $totalOrderPrice);
    }

    private function updatedProductAmount($availableQty, $orderQty){
        return $availableQty - $orderQty;
    }

    private function updatedUserCredit($userCredit, $totalOrderPrice){
        return $userCredit - $totalOrderPrice;
    }

    private function formatOrderResponse($productName, $totalOrderPrice, $updatedUserCredit){
        return [
            "total" => $totalOrderPrice,
            "product" => $productName,
            "change" => $updatedUserCredit,
        ];
    }

}
