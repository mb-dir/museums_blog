<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $search = request('search');
        $posts = Post::where(function ($query) use ($search) {
            if ($search) {
                $query->where('tags', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%');
            }
        })
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $comments = $post->comments;
        return view('posts.show', compact('post', 'comments'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        if (Gate::allows('is-active')) {
            $validatedData = $request->validated();
            $photoPath = $request->file('photo')->store('logos', 'public');

            $post = Post::create([
                'title' => $validatedData['title'],
                'tags' => $validatedData['tags'],
                'content' => $validatedData['content'],
                'photo' => $photoPath,
                'date' => now(),
                'user_id' => auth()->id(),
                'score' => 8,
            ]);

            $user = User::find(auth()->id());
            $user->score += $post->score;
            $user->save();

            $rankings = [1, 2, 3, 4, 5];
            foreach ($rankings as $rank) {
                if ($user->score >= $rank * 20) {
                    $user->rankings()->syncWithoutDetaching([$rank]);
                }
            }

            $message = [
                'content' => "Post został utworzony",
                'type' => 'success',
            ];

            return redirect('/')->with('message', $message);
        } else {
            abort(403);
        }
    }

    public function delete(Post $post)
    {
        if (Gate::allows('post-operation', $post)) {
            $post->delete();
            $message = [
                'content' => "Post został usunięty",
                'type' => 'delete',
            ];
            return redirect('/')->with('message', $message);
        } else {
            abort(403);
        }
    }

    public function edit(Post $post)
    {
        if (Gate::allows('post-operation', $post)) {
            return view('posts.edit', compact('post'));
        } else {
            abort(403);
        }
    }

    public function update(EditPostRequest $request, Post $post)
    {
        if (Gate::allows('post-operation', $post)) {
            $formFields = $request->validated();
            $post->update($formFields);

            $message = [
                'content' => "Post został zaaktualizowany",
                'type' => 'success',
            ];

            return redirect('/posts/'.$post->id)->with('message', $message);
        } else {
            abort(403);
        }
    }
}
