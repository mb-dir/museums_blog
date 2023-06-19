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
            $users = null;
            $userPosts = $user->posts;

            if ($user->role === 'admin') {
                $users = User::where('role', 'user')->get();
            }

            $rankings = $user->rankings;

            return view('users.show', compact('users', 'rankings', 'userPosts'));
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
        return redirect('/user-info/'.auth()->user()->id)->with('message', $message);
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
            $redirectUrl = $isAdmin ? '/user-info/'.auth()->user()->id : '/user-info/'.$user->id;

            return redirect($redirectUrl)->with('message', $message);
        } else {
            abort(403);
        }
    }

    public function showUser(User $user)
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }
        $rankings = $user->rankings;
        $userPosts = $user->posts;
        return view('users.admin.show', compact('user', 'rankings', 'userPosts'));
    }

    public function changeUserStatus(User $user)
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
