<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

use App\Mails\RegisterMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller {

  public function create(Request $request) 
  {
    $validator = Validator::make($request->all(), [
      'f_name' => ['required', 'max:255', 'string'],
      'l_name' => ['required', 'max:255', 'string'],
      'email' => ['required', 'email', 'max:255', 'unique:users,email', 'string'],
      'phone' => ['required', 'max:255', 'string', 'unique:users,phone'],
      'password' => ['required', 'string', 'min:6'],
      'address' => ['required', 'string'],
      'type' => ['required', 'string']
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
    $user->type = $request->type;
    $user->nbi_id = isset($request->nbi_id) ? $request->nbi_id : null;
    $user->dti_id = isset($request->dti_id) ? $request->dti_id : null;
    $user->picture = $request->picture;

    $user->save();
    // Send email notification to successfull registered user
    // Mail::to($request->email)
    //         ->send(new RegisterMail('Pick App', $request->f_name));

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

  public function changePassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'new_password' => ['required', 'string'],
      'current_password' => ['required', 'string']
    ]);

    if ($validator->fails()) {
      return response()->json([
        "status" => false,
        "message" => 'Invalid details!',
        "errors" => $validator->errors()
      ], 200);
    }

    $user = User::where('id', Auth::user()->id)->first();

    if ($user != null) {
      if (Hash::check($request->current_password, $user->password)) {
          $user->password = Hash::make($request->new_password);
          $user->save();
          
          return new UserResource($user);
      }
    }

    return response()->json([
      "status" => false,
      "message" => 'Invalid credentials',
    ], 200);
  }

}