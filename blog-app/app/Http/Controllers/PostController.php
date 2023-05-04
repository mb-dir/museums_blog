<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Ranking;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $rankings = Ranking::with('users')->get();
        $posts = Post::where(function ($query) {
            $search = request('search');
            if ($search) {
                $query->where('tags', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%');
            }
        })
        ->orderByDesc('created_at')
        ->paginate(4);
        return view('posts.index', ['posts'=>$posts, 'rankings'=>$rankings]);
    }

    //show single
    public function show(Post $post)
    {
        $comments = $post->comments;
        return view('posts.show', ['post'=>$post, 'comments'=>$comments]);
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

        //Increase user score
        $user = auth()->user();
        $user->score += 2;
        // it works
        $user->update();

        return Redirect('/')->with('message', "Post został utworzony");
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/')->with('message', "Post zosatł usunięty");
    }

    public function edit(Post $post){
    return view('posts.edit', [
      "post"=> $post
    ]);
  }

    public function update(Request $request, Post $post)
    {
        $formFields = $request->validate([
            'title'=>'required',
            'tags'=>'required',
            'content'=>'required',
        ]);
        $post->update($formFields);

        return redirect('/')->with('message', "Post został zaaktualizowany");
    }
}
