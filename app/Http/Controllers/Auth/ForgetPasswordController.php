<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordVerificationNotification;

class ForgetPasswordController extends Controller
{
    public function forgetPassword(ForgetPasswordRequest $request){
        $request->only("email");
        $user = User::where("email",$request->email)->first();
        $user->notify(new ResetPasswordVerificationNotification());
        return response()->json([
            "message" => "the email has been sent to you, please check your email"
        ]);
    }
}
