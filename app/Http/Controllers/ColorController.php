<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('id', 'desc')->get();
        return view('admin.create_color', ['colors' => $colors]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'color' => 'required|max:255'
        ]);

        Color::UpdateOrCreate($data);

        return back();
    }

    public function destroy(string $colorId)
    {
        Color::destroy($colorId);

        return back();
    }
}
