<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CommentController extends Controller{
    public function store(Request $request, Post $post){
        $validatedData = $request->validate([
            'content' => 'required'
        ]);

        $comment = new Comment;
        $comment->content = $validatedData['content'];
        $comment->date = now();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post->id;
        $comment->save();

        // Increase user score
        $user = User::find(auth()->id());
        $user->score += 2;
        $user->update();

        return redirect()->back()->with('message', 'Komentarz został dodany');
    }
}
