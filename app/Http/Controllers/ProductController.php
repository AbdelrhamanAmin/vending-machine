<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =  $this->productService->list();
        return $this->handleResponse($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->create($request);
            return $this->handleResponse($product, 'Product added successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {

        if($this->productService->authorizeProduct($id) === false){
            return $this->handleError('Update Failed.', ['error'=>'Unauthorized'], 422);
        }
        $product = Product::find($id);
        $product->update($request->all());
        return $this->handleResponse($product, 'Product Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->productService->authorizeProduct($id) === false){
            return $this->handleError('Delete Failed.', ['error'=>'Unauthorized'], 422);
        }
        $product = Product::where('id',$id)->delete();
        if($product){
            return $this->handleResponse($product, 'Product Deleted successfully');
        }
        else{
            return $this->handleError('Delete Failed.', ['error'=>'Not Found'], 404);
        }
    }
}
