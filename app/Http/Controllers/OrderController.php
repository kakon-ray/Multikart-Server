<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Models\Color;
use App\Models\Image;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDO;
use PhpParser\Node\Stmt\Foreach_;

class OrderController extends Controller
{
    // show all orders to admin
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate('1');
        $images = Image::all()->unique('product_id');
        $items = Item::all();
        return view(
            'admin.all_orders',
            [
                'orders' => $orders,
                'images' => $images,
                'items' => $items,
            ]
        );
    }

    // add to cart
    public function addcart(Request $request, $id)
    {
        $product = Product::find($id);
        $cartItem = session("cart", []);

        $newItem = [
            "id" => $product["id"],
            "title" => $product["title"],
            "price" => $product["price"],
            "color" => $request->input("color"),
            "size" => $request->input("size"),
            "quantity" => $request->input("quantity"),
            "image" => Image::where("product_id", $id)
                ->get("image_path")
                ->first(),
            "subtotal" => $product["price"] * $request->input("quantity"),
        ];

        $cartItem[] = $newItem;

        session(["cart" => $cartItem]);
        return redirect(route("cart"));
    }

    // create orders
    public function order(Request $request)
    {
        $user_id = $request->user()->id;
        Order::create([
            "user_id" => $request->user()->id,
            "total_amount" => array_sum(
                array_column(session("cart"), "subtotal")
            ),
            "payment_method" => "COD",
        ]);

        $order_id = Order::where("user_id", $request->user()->id)
            ->get()
            ->last()->id;

        foreach (session("cart") as $item) {
            Item::create([
                "order_id" => $order_id,
                "product_id" => $item["id"],
                "user_id" => $user_id,
                "product_name" => $item["title"],
                "size" => $item["size"],
                "color" => $item["color"],
                "unit_price" => $item["price"],
                "quantity" => $item["quantity"],
            ]);

            $size_id = Size::where('size', $item["size"])->get()->first();
            $color_id = Color::where('color', $item["color"])->get()->first();

            ProductVariant::where('product_id', $item["id"])
                ->where('color_id', $color_id->id)
                ->where('size_id', $size_id->id)
                ->decrement('stock', $item["quantity"]);
        }

        $items = Item::where("order_id", $order_id)->get();

        Mail::to($request->user())->send(new OrderPlaced($items));

        session()->forget("cart");

        return redirect()
            ->route("myorders")
            ->with("orderSuccess", "Order placed Successfully");
    }

    //my orders
    public function myorders(Request $request)
    {
        // getting all orders of the current customer
        $orders = Order::where("user_id", $request->user()->id)
            ->get();

        // getting items where the order is the current customers
        $items = Item::where('user_id', $request->user()->id)->get()->all();
        $product_id = [];

        foreach ($items as $item) {
            $product_id[] = $item->product_id;
        }

        $images = Image::whereIn('product_id', $product_id)->get()->unique('product_id');
        $items = Item::whereIn('product_id', $product_id)->get();

        return view("pages.my_orders", [
            "orders" => $orders,
            "items" => $items,
            "images" => $images,
            "items" => $items,
        ]);
    } //my orders

    public function order_done($order_id)
    {
        Order::where('id', $order_id)->update([
            'status' => 1
        ]);

        return back()->with('message', 'Status Updated Successfully');
    }

    public function deleteCartItem(Request $request, $id)
    {
        session()->forget("cart." . $id);
        return redirect()->route("cart");
    }
}
