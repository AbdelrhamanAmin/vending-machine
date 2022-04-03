<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\User;
use App\Services\OrderService;

class OrderController extends Controller
{

    protected $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }


    public function create(OrderRequest $request)
    {
        if(Auth()->user()->role !== User::BUYER_ROLE) {
            return $this->handleError('Unauthorized.', ['error'=>'Unauthorized']);
        }
        try {
            $order = $this->orderService->create($request['product_id'], $request['qty']);
            return $this->handleResponse($order, 'Order created successfully');
        } catch (\Exception $ex) {
            return $this->handleError($ex->getMessage(), null, 422);
        }
        if($order){
        }else{
        }
    }
}
