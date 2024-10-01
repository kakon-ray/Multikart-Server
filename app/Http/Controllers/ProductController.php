<?php

namespace App\Http\Controllers;

use App\Events\NewProduct;
use App\Models\Category;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // display all product to users
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(2);
        $images = Image::all();
        return view('pages.shop', [
            'products' => $products,
            'images' => $images
        ]);
    }

    // list all product to admin
    public function productlist()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(2);
        $stock = ProductVariant::all();
        $images = Image::all();

        return view('admin.product_list', [
            'products' => $products,
            'stocks' => $stock,
            'images' => $images
        ]);
    }

    // create product page show to admin
    public function addproduct()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('admin.add_product', ['categories' => $categories, 'colors' => $colors, 'sizes' => $sizes]);
    }

    // store new product
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'category' => 'required',
            'price' => 'required',
            'images' => 'required',
            'images.*' => 'required|mimes:jpeg,png,jpg|max:2048',
            'color.*' => 'required',
            'size.*' => 'required',
            'stock.*' => 'required'
        ], [
            'images.required' => 'Please choose an image.',
            'images.*.mimes' => 'The image field must be a file of type: jpeg, png, jpg.',
            'images.*.max' => 'The image should not exceed 2mb',
        ]);

        $product = Product::create(
            $request->only(['title', 'description', 'category', 'price'])
        );

        $variants = array_map(function ($color, $size, $stock) {
            return array(
                'color' => $color,
                'size' => $size,
                'stock' => $stock
            );
        }, $data['color'], $data['size'], $data['stock']);

        $product_id = $product->id;

        foreach ($variants as $variant) {
            Color::updateOrInsert([
                'color' => $variant['color']
            ]);

            Size::updateOrInsert([
                'size' => $variant['size']
            ]);

            $color_id = Color::where('color', $variant['color'])->first()->id;
            $size_id = Size::where('size', $variant['size'])->first()->id;

            ProductVariant::create([
                'product_id' => $product_id,
                'color_id' => $color_id,
                'size_id' => $size_id,
                'stock' => $variant['stock']
            ]);
        }

        foreach ($data['images'] as $image) {
            //store to public folder
            $file_name = time() . $image->getClientOriginalName();
            $path =  public_path() . '/product_images';
            $image->move($path,  $file_name);

            Image::create([
                'product_id' => $product_id,
                'image_path' => $file_name
            ]);
        }

        event(new NewProduct());
        return redirect()->route('addproduct')->with('message', 'Product added succesfully');
    }

    // display single product to users
    public function show($product_id)
    {
        $product = Product::find($product_id);
        $images = Image::where('product_id', $product_id)->get();
        $colors = ProductVariant::where('product_id', $product->id)->get()->unique('color.id');
        $sizes = ProductVariant::where('product_id', $product->id)->get()->unique('size.id');

        return view('pages.detail', [
            'product' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
            'images' => $images
        ]);
    }

    // show the edit page to admin
    public function edit($id)
    {
        $product = Product::find($id);
        $product_variants = ProductVariant::where('product_id', $id)->get();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.edit_page', [
            'product' => $product,
            'product_variants' => $product_variants,
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }

    // update a product
    public function update(Request $request, Product $product)
    {

        $old_variants = json_decode($request->product_variants);

        Product::find($product->id)
            ->update($request->only(['title', 'description', 'category', 'price']));

        $variants = array_map(function ($color, $size, $stock) {
            return array(
                "color" => $color,
                "size" => $size,
                "stock" => $stock
            );
        }, $request->color, $request->size, $request->stock);

        foreach ($variants as $key => $variant) {

            $color_id = Color::where('color', $variant['color'])->first()->id;
            $size_id = Size::where('size', $variant['size'])->first()->id;
            $old_color_id = $old_variants[$key]->color_id;
            $old_size_id = $old_variants[$key]->size_id;

            ProductVariant::where('product_id', $product->id)
                ->where('color_id', $old_color_id)
                ->where('size_id', $old_size_id)
                ->update([
                    'color_id' => $color_id,
                    'size_id' => $size_id,
                    'stock' => $variant['stock']
                ]);
        }
        return redirect()->route('productlist')->with('message', 'product updated succesfully');
    }

    // delete a product
    public function destroy(Product $product)
    {
        Product::find($product->id)->delete();
        return redirect()->route('productlist')->with('success', 'Product deleted successfully');
    }
}
