<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStatusRequest;
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
                 
                    deleteImage($product->image, 'product');
                }
                $data['image'] = uploadImage($request->file('image'), 'Products');
            }
                
            $product->update($data);
            
            return $this->success(data:new ProductResource($product),message:'Product updated successfully',status: 200);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }

    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return $this->success(message:'Product deleted successfully', status:200);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }
    // restore deleted product

    public function restore($id)
    {
        try{
            $product = Product::withTrashed()->findOrFail($id);
             // Check if the product is already restored
            if (!$product->trashed()) {
            
                return $this->success(message: 'Product has already been restored.',status: 200);
            }
                $product->restore();

            return $this->success(data:new ProductResource($product),message:'Product restored successfully', status:200);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }
    
    public function show (Product $product)
    {
        try{
            if ($product->status == 0) {
                return $this->failure('This product is not available for show casue it\'s status = false', 400);
            }
            return $this->success(data:new ProductResource($product),message:'Product retrieved successfully', status:200);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }
    // Change the status of a product (PATCH /api/products/{id}/status) between active and  inactive. 
    public function changeStatus(Product $product)
    {
        try {
        
            $newStatus = $product->status == "active" ? "inactive" : "active";
            $product->update(['status' => $newStatus]);
            return $this->success(data: new ProductResource($product), message: 'Product status updated successfully', status: 200);
        } catch (\Throwable $e) {
            // Return failure response with error message
            return $this->failure($e->getMessage(), 500);
        }
    }
    
    // filter products
    public function productFilter()
    {
       
        
        try {
      
            $name = $this->getArrayFromRequest(request('name'));
           
            $status = $this->getArrayFromRequest(request('status'));
            $minPrice = request('min_price');
            $maxPrice = request('max_price');
            $orderDirection = request('sort', 'desc'); 
            $query = Product::query();
            
            $query->when(!empty($name), fn($q) => $this->filterInArray($q, 'name', $name));
            $query->when(!empty($status), fn($q) => $this->filterInArray($q, 'status', $status));
            if (isset($minPrice) && isset($maxPrice)) {
                $query->whereRaw('price BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            } elseif (isset($minPrice)) {
                $query->whereRaw('price >= ?', [$minPrice]);
            } elseif (isset($maxPrice)) {
                $query->whereRaw('price <= ?', [$maxPrice]);
            }
            $query->orderBy('price','asc')->orderBy('created_at', $orderDirection);

            $perPage = 10;
            $products = $query->paginate($perPage);
            
            $data = ProductResource::collection($products);
            if($data->isEmpty()){
                return $this->success(data:[],message: 'No products found', status: 200);
            }
            return $this->successWithPagination(data:$data,message: "products per page" );

     } catch (\Exception $e) {
            return $this->failure(message: $e->getMessage());
        }

    }
    private function getArrayFromRequest($param): array
    {
        return is_array($param) ? $param : (isset($param) ? explode(',', $param) : []);
    }
    private function filterInArray($query, $column, $values)
    {   
        
        if(!is_array($values)) return $query->Where($column,$values);
        else return $query->WhereIn($column, $values);
    }
 
    
    
}
