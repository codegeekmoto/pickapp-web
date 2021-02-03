<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

use App\Mails\RegisterMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Resources\ErrorResource;

class UserController extends Controller {

  public function create(Request $request) 
  {
    $validator = Validator::make($request->all(), [
      'f_name' => ['required', 'max:255', 'string'],
      'l_name' => ['required', 'max:255', 'string'],
      'email' => ['required', 'email', 'max:255', 'unique:users,email', 'string'],
      'phone' => ['required', 'max:255', 'string', 'unique:users,phone'],
      'password' => ['required', 'string', 'min:6'],
      'address' => ['required', 'string']
    ]);

    if ($validator->fails()) {
      // The given data did not pass validation
      return response()->json([
        "status" => false,
        "message" => 'Invalid details!',
        "errors" => $validator->errors()
      ], 200);
    }
 
    $user = new User();
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->f_name = $request->f_name;
    $user->l_name = $request->l_name;
    $user->phone = $request->phone;
    $user->picture = $request->picture;

    $user->save();
    // Send email notification to successfull registered user
    Mail::to($request->email)
            ->send(new RegisterMail('Pick App', $request->f_name));

    return new UserResource($user);
  }

  public function updateEmail(Request $request)
  {
    $validator = Validator::make($request->all(),[ 
      'email' => ['required', 'email', 'max:255', 'unique:users,email', 'string']
    ]);

    if ($validator->fails()) {
      return response()->json([
        "status" => false,
        "message" => 'Invalid details!',
        "errors" => $validator->errors(),
      ], 200);
    }

    $user = Auth::user();
    $user->email = $request->email;
    $user->save();

    return new UserResource($user);
  }

  public function updatePhone(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'phone' => ['required', 'max:255', 'string', 'unique:users,phone']
    ]);

    if ($validator->fails()) {
      return response()->json([
        "status" => false,
        "message" => 'Invalid details!',
        "errors" => $validator->errors()
      ], 200);
    }

    $user = Auth::user();
    $user->phone = $request->phone;
    $user->save();

    return new UserResource($user);
  }

  public function updateAddress(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'address' => ['required', 'string']
    ]);

    if ($validator->fails()) {
      return response()->json([
        "status" => false,
        "message" => 'Invalid details!',
        "errors" => $validator->errors()
      ], 200);
    }

    $user = Auth::user();
    $user->address = $request->address;
    $user->save();

    return new UserResource($user);
  }

}