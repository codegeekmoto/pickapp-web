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
      'f_name' => ['max:255', 'string'],
      'l_name' => ['max:255', 'string'],
      'email' => ['email', 'max:255', 'unique:users,email', 'string'],
      'phone' => ['max:255', 'string', 'unique:users,phone'],
      'password' => ['string', 'min:6'],
      // 'confirm_password' => ['required_with:password', 'same:password'],
    ]);

    if ($validator->fails()) {
      // The given data did not pass validation
      return response()->json(['data' => [
        "status" => false,
        "message" => 'Invalid details!',
        "errors" => $validator->errors()
      ]], 200);
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

  public function getAll(Request $request)
  {
    $user = User::all();
    return UserResource::collection($user);
  }

  public function update(Request $request)
  {
    echo '';
  }

}