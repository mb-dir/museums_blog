<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller {
    public function index(){
        $posts = Post::where(function ($query) {
            $search = request('search');
            if ($search) {
                $query->where('tags', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%');
            }
        })
        ->orderByDesc('created_at')
        ->paginate(8);
        return view('posts.index', ['posts'=>$posts]);
    }

    //show single
    public function show(Post $post){
        $comments = $post->comments;
        return view('posts.show', ['post'=>$post, 'comments'=>$comments]);
    }

    // craete view
    public function create(){
        return view('posts.create');
    }

    // create logic
    public function store(CreatePostRequest $request){
        if (Gate::allows('is-active')) {
            $validData = $request->validated();
            $validData['photo']=$request->file('photo')->store('logos', 'public');

            // Create a new post instance
            $post = new Post;
            $post->title = $validData['title'];
            $post->tags = $validData['tags'];
            $post->content = $validData['content'];
            $post->photo = $validData['photo'];
            $post->date = now();
            $post->user_id = auth()->id();
            $post->score = 8;

            $post->save();

            // Increase user score
            $user = User::find(auth()->id());
            $user->score += $post->score;
            $user->update();

            $rankings = [1, 2, 3, 4, 5];
            foreach($rankings as $rank){
                if($user->score >= $rank * 20){
                    $user->rankings()->syncWithoutDetaching([$rank]);
                }
            }
            $message = [
                'content' => "Post został utworzony",
                'type' => 'success'
            ];

            return Redirect('/')->with('message', $message);
        } else {
            abort(403);
        }
    }

    public function delete(Post $post){
        if (Gate::allows('post-operation', $post)) {
            $post->delete();
            $message = [
                'content' => "Post został usunięty",
                'type' => 'delete'
            ];
            return redirect('/')->with('message', $message);
        } else {
            abort(403);
        }
    }

    public function edit(Post $post){
        if (Gate::allows('post-operation', $post)) {
            return view('posts.edit', ["post"=>$post]);
        } else {
            abort(403);
        }
    }

    public function update(EditPostRequest $request, Post $post){
        if (Gate::allows('post-operation', $post)) {
            $formFields = $request->validated();
            $post->update($formFields);

            $message = [
                'content' => "Post został zaaktualizowany",
                'type' => 'success'
            ];

            return redirect('/posts/'.$post->id)->with('message', $message);
        } else {
            abort(403);
        }
    }
}
