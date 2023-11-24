<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function delete(Post $post){
        if(auth()->user()->cannot('delete', $post)){
            return 'you cannot do it';
        }
        $post->delete();
        return redirect('/profile/'.auth()->user()->username)->with('success', 'message deleted');
    }
    
    public function viewSinglePost(Post $post){
        
        //adding markdown lang to post text area
        $post['body']=Str::markdown($post->body);
        return view('single-post', ['post'=>$post]);
    }
    
    public function storeNewPost(Request $request){
        $incomingFields=$request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $incomingFields['user_id']=auth()->id();

        $newPost=Post::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'new post created');
    }
    
    public function showCreateForm(){
        
        return view('create-post');

    }
}
