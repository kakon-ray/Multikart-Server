<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->get();
        return view('admin.create_size', ['sizes' => $sizes]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'size' => 'required|max:255'
        ]);

        Size::UpdateOrCreate($data);

        return back()->with('message', 'Size Added');
    }

    public function destroy(string $sizeId)
    {
        Size::destroy($sizeId);

        return back();
    }
}
