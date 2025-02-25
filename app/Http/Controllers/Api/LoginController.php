<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobilesetting;
use App\Models\Settings;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function test()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Test Successful.'
        ], 200);
    }

    public function login(Request $request)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Generate JWT token
            $token = Auth::guard('api')->login($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ],200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }
    }

    public function settings(Request $request)
    {
        Mobilesetting::create([
            'main_color' => $request->main_color,
            'cart_color' => $request->cart_color,
            'button_color' => $request->button_color,
            'text_color' => $request->text_color
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'settings updated successfully.'
        ],200);
    }

    public function colors()
    {
        $colors = Mobilesetting::select('main_color','cart_color','button_color','text_color')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'colors showing successfully.',
            'colors' => $colors
        ]);
    }

}
