<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{
    public function logout(Request $request) : JsonResponse  {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error logging out'], 500);
        }

    }
}
