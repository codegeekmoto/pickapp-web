<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StoreResource;


class StoreController  extends Controller {

    public function create(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'dti' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'business_permit' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            // The given data did not pass validation
            return response()->json([
              "status" => false,
              "message" => 'Invalid details!',
              "errors" => $validator->errors()
            ], 200);
        }

        $store = new Store();
        $store->seller_id = Auth::user()->id;
        $store->dti = $request->dti;
        $store->name = $request->name;
        $store->description = $request->description;
        $store->business_permit = $request->business_permit;
        $store->address = $request->address;
        $store->save();
        
        return new StoreResource($store);
    }

}