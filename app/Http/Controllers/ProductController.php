<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        
        //return Product::all();
        //return ProductResource::collection(Product::all());
        return new ProductCollection(Product::paginate(5));
    }

    public function store(StoreProductRequest $request)
    {
        //
        $product = Product::create($request->all());

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        $product = new ProductResource($product);
        return $product;
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json();
    }
}
