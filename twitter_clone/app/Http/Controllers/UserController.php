<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //why function should use public/private
    public function register(Request $request){
        $incomingFields= $request->validate([
            'username'=>['required', 'min:3','max:20',Rule::unique('users','username')],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','min:8','confirmed'] //confirmed make sure the 2 password field are the same
        ]);
        //hashing password in db
        $incomingFields['password']=bcrypt($incomingFields['password']);
        User::create($incomingFields);
        return "they don't know me son";
    }
}
