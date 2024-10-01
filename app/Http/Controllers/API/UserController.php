<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function user_login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Generate a random token
        $token = Str::random(60);
    
        // Check if the user exists, or create a new user
        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['remember_token' => $token] // Set the token if creating a new user
        );
    
        // Optionally update the token if the user already exists
        if ($user->wasRecentlyCreated === false) {
            $user->remember_token = $token;
            $user->save();
        }
    
        return response()->json([
            'status' => true,
            'accessToken' => $token,
        ]);
    }
}