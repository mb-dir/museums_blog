<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

       return view('posts.index', ['posts'=>$posts]);
    }

    //show single
    public function show(Post $post)
    {
        return view('posts.show', ['post'=>$post]);
    }

    // craete view
    public function create()
    {
        return view('posts.create');
    }

    // create logic
    public function store(Request $request)
    {
        $formFields = $request->validate([
        'title'=>'required',
        'tags'=>'required',
        'content'=>'required',
        ]);
        $formFields['date'] = date('Y-m-d');
        $formFields['user_id']=auth()->id();

        Post::create($formFields);

        return Redirect('/')->with('message', "Post został utworzony");
    }
}
