<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Hamcrest\Number\OrderingComparison;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
})->name('index');

Route::get('cart', function () {
    return view('pages.cart');
})->name('cart');

Route::get('checkout', function () {
    return view('pages.checkout');
})->name('checkout');

Route::post('deleteCartItem/{id}', [OrderController::class, 'deleteCartItem'])->middleware(['auth', 'verified'])->name('deleteCartItem');
Route::get('detail/{product_id}', [ProductController::class, 'show'])->name('detail');
Route::get('shop', [ProductController::class, 'index'])->name('shop');
Route::get('myorders', [OrderController::class, 'myorders'])->middleware(['auth', 'verified'])->name('myorders');
Route::post('addcart/{id}', [OrderController::class, 'addcart'])->name('addcart');
Route::post('order', [OrderController::class, 'order'])->middleware(['auth', 'verified'])->name('order');

/* Admin Routes */
Route::prefix('admin')->group(function () {
    // admin login page load
    Route::get('login', [AdminController::class, 'index'])->name('admin.login');
    // admin login
    Route::post('login', [AdminController::class, 'login'])->name('admin.log_in');
    // admin logout
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout')->middleware(['admin']);
    // add product page load
    Route::get('addproduct', [ProductController::class, 'addproduct'])->name('addproduct')->middleware(['admin']);
    // product list page load
    Route::get('productlist', [ProductController::class, 'productlist'])->name('productlist')->middleware(['admin']);

    // create category page load
    Route::get('/create-category', [CategoryController::class, 'index'])->name('create_category')->middleware(['admin']);
    // create category
    Route::post('/create-category', [CategoryController::class, 'store'])->middleware(['admin']);
    // Delete Category
    Route::delete('/delete-category/{categoryId}', [CategoryController::class, 'destroy'])->name('delete_category')->middleware(['admin']);

    // create color page load
    Route::get('/create-color', [ColorController::class, 'index'])->name('create_color')->middleware(['admin']);
    // create color
    Route::post('/create-color', [ColorController::class, 'store'])->middleware(['admin']);
    // Delete color
    Route::delete('/delete-color/{colorId}', [ColorController::class, 'destroy'])->name('delete_color')->middleware(['admin']);

    // create size page load
    Route::get('/create-size', [SizeController::class, 'index'])->name('create_size')->middleware(['admin']);
    // create size
    Route::post('/create-size', [SizeController::class, 'store'])->name('create_size')->middleware(['admin']);
    // Delete size
    Route::delete('/delete-size/{sizeId}', [SizeController::class, 'destroy'])->name('delete_size')->middleware(['admin']);

    // show all orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::put('order-done/{id}', [OrderController::class, 'order_done'])->middleware(['admin'])->name('order_done');
    // product resource route
    Route::resource('product', ProductController::class)->middleware(['admin']);
});


Route::get('/upload-page', function () {
    return view("video_upload");
});

Route::post('/video-upload', function (\Illuminate\Http\Request $request) {
    dd($request->all());
});


/* Admin Routes */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
