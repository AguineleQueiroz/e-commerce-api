<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected Product $repository)
    {
        //...
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = $this->repository->paginate();
        if(!$product) {
            return response()->json(["message" => "Product list is empty."], 204);
        }
        return ProductResource::collection($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProductRequest $request)
    {   $data = $request->validated();
        $product = $this->repository->create($data);
        return (new ProductResource($product))
            ->response()
            ->json(["message" => "Product was created successfuly."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_found = $this->repository->findOrFail($id);
        if(!$product_found) {
            return response()->json(["message" => "Product not found."], 404);
        }
        return new ProductResource($product_found);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateProductRequest $request, string $id)
    {
        $new_data_product = $request->validated();
        $product = $this->repository->findOrFail($id);
        if(!$product) {
            return response()->json(["message" => "Product does not exist."], 404);
        }
        $product->update($new_data_product);
        return (new ProductResource($product))
            ->response()
            ->json(["message" => "Product was updated successfuly."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->repository->findOrFail($id);
        if(!$product) {
            return response()->json(["message" => "Product does not exist."], 404);
        }
        $product->delete();
        return response()->json(["message" => "Product was removed successfuly."]);
    }
}
