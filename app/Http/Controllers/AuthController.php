<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($request->username === 'Daptee' && $request->password === 'Daptee2025') {
                $token = bin2hex(random_bytes(32));
                return response()->json(['token' => $token]);
            }

            return response()->json(['message' => 'Unauthenticated'], 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Login error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
