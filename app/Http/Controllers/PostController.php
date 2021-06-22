<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->with('user','likes')->paginate(20);
        return view('posts.index',[
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show',[
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        //validation
        $this->validate($request,[
            'body' => 'required'
        ]);

        // save post
        $request->user()->posts()->create($request->only('body'));

        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]);

        // Post::create([
        //     'user_id' => auth()->user()->id,
        //     'body' => $request->body 
        // ]);

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        // if($post->ownedBy(auth()->user())){
        $post->delete();
        // }
        
        return back();
    }
}
