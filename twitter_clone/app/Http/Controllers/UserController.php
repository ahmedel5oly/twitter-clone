<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Illuminate\Validation\Rule;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class UserController extends Controller
{
    public function profile(User $user){ //pass to function to call user from db when use model(User) the variable need to match the name in the route
        
        return view('profile-posts', ['username'=> $user->username, 'posts'=> $user->posts()->latest()->get(), 'postCount'=>$user->posts()->count()]);
    }
    
    public function storeAvatar(Request $request){
        $request->validate([
            'avatar' => ['required', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);
        $user=auth()->user();
        $imgData=Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put("public/avatars/{$user->id}.jpg", $imgData);
    }
    public function showAvatarForm(){
        return view('avatar-form');
    }
    public function logout(){
        auth()->logout();
        return redirect('/')->with('success', 'you have loggedout');;
    }
    
    public function showCorrectHomepage(){
        if(auth()->check()){
            return view('homepage-feed');
        } else{
            return view('homepage');
        }
    }
    
    public function loginapi(Request $request){
        $incomingFields=$request->validate([
            'username'=>['required'],
            'password'=>['required']
        ]);
        if(auth()->attempt($incomingFields)){
            $user=User::where('username', $incomingFields['username']);
            $token=$user->createToken('ourapptoken')->plainTextToken;
            return $token;
        }
        return '';
    }
    public Function login(Request $request){
        $incomingFields=$request->validate([
            'loginusername'=>['required'],
            'loginpassword'=>['required']
        ]);
        if(auth()->attempt(['username'=>$incomingFields['loginusername'], 'password'=>$incomingFields['loginpassword']])){
            //use session method to send cookie to browser to keep the user loged in all over the pages
            $request->session()->regenerate();
            return redirect('/')->with('success', 'you have loggedin');
        }else{
            return redirect('/')->with('failure', 'invalid login');
        }
    }

    public function register(Request $request){
        $incomingFields= $request->validate([
            'username'=>['required', 'min:3','max:20',Rule::unique('users','username')],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','min:8','confirmed'] //confirmed make sure the 2 password field are the same
        ]);
        //hashing password in db
        $incomingFields['password']=bcrypt($incomingFields['password']);
        $user=User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success','you have created new account');
    }
}
