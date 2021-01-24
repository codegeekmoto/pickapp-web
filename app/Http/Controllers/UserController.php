<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mails\TestMail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->email != null) {
            Mail::to($request->email)
            ->send(new TestMail('Pick App', 'Visitor', 'https://tacpickapp.herokuapp.com/'));
        }
        return view('welcome');
    }
}
