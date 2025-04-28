<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        
        try{
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image'] = uploadImage($request->file('image'), 'Products');
            }
            Product::create($data);
            return $this->success('Product created successfully', 201);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
            
    }

    public function update(Product $product,UpdateProductRequest $request)
    {
        try{
            $data = $request->validated();
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($product->image) {
                    deleteImage($product->image, 'Products');
                }
                $data['image'] = uploadImage($request->file('image'), 'Products');
            }
                
            $product->update($data);
            
            return $this->success(data:new ProductResource($product),message:'Product updated successfully',status: 200);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }
    
}
