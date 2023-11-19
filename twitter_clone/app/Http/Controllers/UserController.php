<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class UserController extends Controller
{
    public function showCorrectHomepage(){
        if(auth()->check()){
            return view('homepage-feed');
        } else{
            return view('homepage');
        }
    }
    
    public Function login(Request $request){
        $incomingFields=$request->validate([
            'loginusername'=>['required'],
            'loginpassword'=>['required']
        ]);
        if(auth()->attempt(['username'=>$incomingFields['loginusername'], 'password'=>$incomingFields['loginpassword']])){
            //use session method to send cookie to browser to keep the user loged in all over the pages
            $request->session()->regenerate();
            return 'done mf';
        }else{
            return 'no mf';
        }
    }

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
