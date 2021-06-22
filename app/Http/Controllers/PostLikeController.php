<?php

namespace App\Http\Controllers;

use App\Mail\PostLiked;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }


    public function store(Post $post, Request $request)
    {
        // dd($post->likedBy($request->user()));

        if(!$post->likedBy($request->user())){
            $post->likes()->create([
                'user_id' => $request->user()->id,
            ]);
        }

//        Mail::to($request->user())->send(new PostLiked(auth()->user, $post));

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id',$post->id)->delete();
        return back();
    }
}