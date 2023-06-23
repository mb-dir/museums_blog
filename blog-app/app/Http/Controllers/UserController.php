<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\EditUserRequest;

class UserController extends Controller
{
    public function show(User $user)
    {
        if (!Gate::allows('allow-show-user', $user)) {
            abort(403);
        }
        $userPosts = $user->posts;
        $rankings = $user->rankings;

        return view('users.show', compact('rankings', 'userPosts'));
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
        return redirect()->route('adminPanel')->with('message', $message);
    }

    public function edit(User $user)
    {
        if (!Gate::allows('allow-update-user', $user)) {
            abort(403);
        }
        return view('users.edit', compact('user'));
    }

    public function update(EditUserRequest $request, User $user)
    {
        if (!Gate::allows('allow-update-user', $user)) {
            abort(403);
        }
        $formFields = $request->validated();
        $user->update($formFields);

        $message = [
            'content' => "Profil został zaaktualizowany",
            'type' => 'success'
        ];

        // if user is admin and doesn't edit his profie
        $isAdmin = Auth::user()->role === "admin" && Auth::id() !== $user->id;
        $redirectRoute = $isAdmin ? 'adminPanel.users.show' : 'users.show';

        return redirect()->route($redirectRoute, compact('user'))->with('message', $message);
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
