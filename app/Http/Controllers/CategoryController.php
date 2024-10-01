<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categorys = Category::orderBy('id', 'desc')->get();
        return view('admin.create_category', ['categorys' => $categorys]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|max:255'
        ]);

        Category::updateOrInsert($data);

        return back();
    }

    public function destroy(string $colorId)
    {
        Category::destroy($colorId);

        return back();
    }
}
