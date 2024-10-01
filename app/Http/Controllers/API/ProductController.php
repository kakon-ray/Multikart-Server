<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get()->map(function($product) {
            $product->images = $product->images->map(function($image) {
                $image->image_path = asset('product_images/' . $image->image_path);
                return $image;
            });
            return $product;
        });
    
        return response()->json([
            'status' => true,
            'data' => $products,
        ]);
    }
    
    public function product_details($id)
    {
        $product = Product::where('id', $id)->first();
        $color_variants = [];
        $size_variants = [];
        $images = [];

        foreach ($product->productVariant as $key => $value) {
            $color_variants[] = $value->color->color;
        }

        foreach ($product->productVariant as $key => $value) {
            $size_variants[] = $value->size->size;
        }

        foreach ($product->images as $key => $value) {
            $images[] =  asset('/product_images/'. $value->image_path);
        }

        // return $product;
        return response()->json([
            'status'=> true,
            'data' => [
                'title' => $product->title,
                'description' => $product->description,
                'category' =>  $product->getCategory->category,
                'colorVariants' => $color_variants,
                'sizeVariants' => $size_variants,
                'images' =>  $images,
                'price' => $product->price,
            ]
        ]);
    }
}
