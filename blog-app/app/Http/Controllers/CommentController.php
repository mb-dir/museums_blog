<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller {
    public function store(Request $request, Post $post) {
        if (Gate::allows('is-active')) {
            $validatedData = $request->validate([
                'content' => 'required'
            ], [
                'content.required' => 'To pole jest wymagane.',
            ]);

            $comment = new Comment;
            $comment->content = $validatedData['content'];
            $comment->date = now();
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $post->id;
            $comment->score = 2;
            $comment->save();

            // Increase user score
            $user = User::find(auth()->id());
            $user->score += $comment->score;
            $user->update();

            $rankings = [1, 2, 3, 4, 5];
            foreach($rankings as $rank){
                if($user->score >= $rank * 20) {
                    $user->rankings()->syncWithoutDetaching([$rank]);
                }
            }

            $message = [
                'content' => "Komentarz został dodany",
                'type' => 'success'
            ];

            return redirect()->back()->with('message', $message);
        }
    }
}
