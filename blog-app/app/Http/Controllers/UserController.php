<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function show(User $user)
    {
        if (auth()->user()->id === $user->id) {
            $userPosts = $user->posts;
            $rankings = $user->rankings;

            return view('users.show', compact('rankings', 'userPosts'));
        } else {
            abort(403);
        }
    }

    public function destroy(User $user)
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }

        $user->delete();

        $message = [
            'content' => "Użytkownik został usunięty",
            'type' => 'success'
        ];
        return redirect('/admin-panel')->with('message', $message);
    }

    public function edit(User $user)
    {
        if (auth()->user()->id === $user->id || auth()->user()->role === 'admin') {
            return view('users.edit', compact('user'));
        } else {
            abort(403);
        }
    }

    public function update(EditUserRequest $request, User $user)
    {
        if (auth()->user()->id === $user->id || auth()->user()->role === 'admin') {
            $formFields = $request->validated();
            $user->update($formFields);

            $message = [
                'content' => "Profil został zaaktualizowany",
                'type' => 'success'
            ];

            $isAdmin = auth()->user()->role === "admin";
            $redirectUrl = $isAdmin ? '/admin-panel' : '/users/'.$user->id;

            return redirect($redirectUrl)->with('message', $message);
        } else {
            abort(403);
        }
    }
    public function changeStatus(User $user)
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }
        $currentStatus = $user->status;
        $user->status = $currentStatus === 'active' ? 'blocked' : 'active';
        $user->save();

        $message = [
            'content' => "Status użytkownika został zmieniony",
            'type' => 'success'
        ];
        return back()->with('message', $message);
    }
}
