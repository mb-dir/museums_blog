<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Post $post)
    {
        if (Gate::allows('is-active')) {
            $validatedData = $request->validated();

            $comment = Comment::create([
                'content' => $validatedData['content'],
                'date' => now(),
                'score' => 2,
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);

            // Increase user score
            $user = User::find(Auth::id());
            $user->score += $comment->score;
            $user->save();

            $rankings = [1, 2, 3, 4, 5];
            foreach ($rankings as $rank) {
                if ($user->score >= $rank * 20) {
                    $user->rankings()->syncWithoutDetaching([$rank]);
                }
            }

            $message = [
                'content' => "Komentarz został dodany",
                'type' => 'success'
            ];

            return redirect()->back()->with('message', $message);
        } else {
            abort(403);
        }
    }
}
