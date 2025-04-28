<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
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
    
}
