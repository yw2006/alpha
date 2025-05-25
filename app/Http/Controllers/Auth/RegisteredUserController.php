<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            "arName"=>['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'max:10240'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable','string','max:255' ],
            "arAddress"=>['nullable','string','max:255' ],
            "role_id" => ["required","integer","exists:roles,id"],
            "advised_by"=>["nullable","integer","exists:users,id" ]
            ]
            );
        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('users', 'public');
        }
        $validated["password"]= Hash::make($validated['password']);
        $user = User::create($validated);
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            "token"=>$token
        ]);
    }
    }

