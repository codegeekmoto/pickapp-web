<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PasswordResetResource;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\Store;

class AuthController extends Controller {

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)
                    ->where('type', $request->type)
                    ->first();

        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                $token = Str::random(60);
                $user->api_token = hash('sha256', $token);
                $user->save();

                $user->store = null;

                if (strtolower($user->type) === 'seller') {
                    $store = Store::where('seller_id', $user->id)->first();
                    $user->store = $store;
                }
                
                return new UserResource($user);
            }
        }

        return response()->json([
            "status" => false,
            "message" => 'Invalid credentials',
        ], 401);
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

    public function resendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        $passwordReset = PasswordReset::find($request->id);

        if ($passwordReset == null) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        return new PasswordResetResource($passwordReset);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);
    
        if ($validator->fails() || !isset($request->otp_code) || !isset($request->email)) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials',
                "errors" => $validator->errors()
            ], 401);
        }

        $resetPassword = PasswordReset::where('code', $request->otp_code)
            ->where('email', $request->email)
            ->first();

        if ($resetPassword == null) {
            return response()->json([
                "status" => false,
                "message" => 'Invalid credentials'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "status" => true,
            "message" => 'Change password success.',
        ], 201);
    }
}