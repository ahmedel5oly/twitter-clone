<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user){
        //you can't follow yourself
       
        //you cannot follow an already followed user
        $newFollow= new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followed_user_id = $user->id;
        $newFollow->save();
    }
    

    public function deleteFollow(){

    }
}
