<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUserController extends Controller
{
    public function authenticate(Request $request):JsonResponse{
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
        $user=User::where('email', $request->email)->firstOrFail();
        if(!Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token=$user->createToken($user->email)->plainTextToken;
        return response()->json(['access_token' => $token,
         'user' => $user,
        ]);
    }   
}
