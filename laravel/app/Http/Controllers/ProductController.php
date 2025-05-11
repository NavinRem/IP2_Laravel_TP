<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProducts()
    {
        return response()->json(Product::all());
    }

    // Post /api/products
    public function createProduct(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json(["message" => "Product created successfully", "product" => $product], 201);
    }

    // Get /api/products/{productId}
    public function getProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }

        return response()->json($product);
    }

    // Patch /api/products/{productId}
    public function updateProduct(Request $request, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $product->update($request->all());

        return response()->json(["message" => "Product updated successfully", "product" => $product]);
    }

    // Delete /api/products/{productId}
    public function deleteProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $product->delete();

        return response()->json(["message" => "Product deleted successfully"]);
    }
}
