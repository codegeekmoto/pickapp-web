<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller {

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => ['required'],
            'category_id' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'num_of_stock' => ['required'],
        ]);
        
        if ($validator->fails()) {
            // The given data did not pass validation
            return response()->json([
              "status" => false,
              "message" => 'Invalid details!',
              "errors" => $validator->errors()
            ], 200);
        }

        $product = new Product();
        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->num_of_stock = $request->num_of_stock;
        $product->save();

        return new ProductResource($product);
    }

    public function getAll()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

}