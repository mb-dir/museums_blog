<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $validatedData = $request->validate([
        'content' => 'required'
    ]);

    $comment = new Comment;
    $comment->content = $validatedData['content'];
    $comment->date = now();
    $comment->user_id = Auth::user()->id;
    $comment->post_id = $post->id;
    $comment->save();

    //Increase user score
    $user = auth()->user();
    $user->score += 1;
    // it works
    $user->update();

    return redirect()->back()->with('message', 'Komentarz został dodany');
}

}
