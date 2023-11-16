<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //why function should use public/private
    public function register(Request $request){
        $incomingFields= $request->validate([
            'username'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);
        User::create($incomingFields);
        return "they don't know me son";
    }
}
