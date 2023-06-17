<?php

namespace App\Http\Controllers;
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
    public function store(Request $request){
        if (Gate::allows('is-active')) {
            $validData = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'content' => 'required',
            'photo' => 'required|image|mimes:jpeg,png|max:300',
        ], [
            'title.required' => 'To pole jest wymagane.',
            'tags.required' => 'To pole jest wymagane.',
            'content.required' => 'To pole jest wymagane.',
            'photo.required' => 'To pole jest wymagane.',
            'photo.image' => 'Wystąpił błąd podczas przesyłania pliku(dopuszczalne formaty to JPEG i PNG, maksymalny rozmiar to 300 kB)',
            'photo.mimes' => 'Wystąpił błąd podczas przesyłania pliku(dopuszczalne formaty to JPEG i PNG, maksymalny rozmiar to 300 kB)',
            'photo.max' => 'Wystąpił błąd podczas przesyłania pliku(dopuszczalne formaty to JPEG i PNG, maksymalny rozmiar to 300 kB)',
        ]);
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

    public function update(Request $request, Post $post){
        if (Gate::allows('post-operation', $post)) {
            $formFields = $request->validate([
            'title'=>'required',
            'tags'=>'required',
            'content'=>'required',
        ], [
            'title.required' => 'To pole jest wymagane.',
            'tags.required' => 'To pole jest wymagane.',
            'content.required' => 'To pole jest wymagane.',
        ]);
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
