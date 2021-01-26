<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PasswordResetResource;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;

use App\Resources\UserResource;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordReset;
use App\Models\User;

class AuthController extends Controller {

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            // The given data did not pass validation
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return new UserResource(Auth::user());
        }else{
            return response()->json([
                "status" => false,
                'message' => 'Invalid credentials',
            ],  401);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        $code = mt_rand(100000, 999999);
        $passwordReset = new PasswordReset();

        $passwordReset->email = $request->email;
        $passwordReset->token = '';
        $passwordReset->code  = $code;
        $passwordReset->save();

        Mail::to($request->email)
            ->send(new PasswordResetMail($code, $user->f_name));

        return new PasswordResetResource($passwordReset);
    }
}