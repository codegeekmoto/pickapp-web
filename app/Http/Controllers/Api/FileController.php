<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Carbon;

class FileController extends Controller {

    public function image(Request $request)
    {
        $file = $request->file('image');
        $uniqueName  = Carbon::now()->timestamp.'_'.$file->getClientOriginalName();
        $imageUrl = '/'.$request->type.'/'.$uniqueName;
        $file->move($request->type, $uniqueName);

        return response()->json([
            'status' => 'success',
            'url' => $imageUrl
        ]);
    }
}