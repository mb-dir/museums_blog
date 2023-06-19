<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller {
    public function show(User $user){
        if (auth()->user()->id === $user->id) {
            $users = null;
            $userPosts = $user->posts;

            if ($user->role === 'admin') {
                // Retrieve all users with the role 'user'
                $users = User::where('role', 'user')->get();
            }

            $rankings = $user->rankings;

            return view('users.show', ['users'=>$users, 'rankings'=>$rankings, 'userPosts'=>$userPosts]);
        } else {
            abort(403);
        }
    }

    public function destroy(User $user){
        // Check if the authenticated user is an admin
        if (!Gate::allows('is-admin')) {
            abort(403, 'Unauthorized');
        }

        // Delete the user
        $user->delete();

        $message = [
            'content' => "Użytkownik został usunięty",
            'type' => 'success'
        ];
        return redirect('/user-info/'.auth()->user()->id)->with('message', $message);
    }

    //Edit user view
    public function edit(User $user){
        if (auth()->user()->id === $user->id || auth()->user()->role === 'admin') {
            return view('users.edit', [
            "user"=> $user
            ]);
        }else{
            abort(403, 'Unauthorized');
        }
    }

    // Update user logic
    public function update(EditUserRequest $request, User $user){
        if (auth()->user()->id === $user->id || auth()->user()->role === 'admin') {
            $formFields = $request->validated();
            $user->update($formFields);

            $message = [
                'content' => "Profil został zaaktualizowany",
                'type' => 'success'
            ];

            $isAdmin = auth()->user()->role === "admin";
            if($isAdmin){
                return redirect('/user-info/'.auth()->user()->id)->with('message', $message);
            }else{
                return redirect('/user-info/'.$user->id)->with('message', $message);
            }
        }else{
            abort(403, 'Unauthorized');
        }
    }

    // Show user for admin
    public function showUser(User $user){
        if (!Gate::allows('is-admin')) {
            abort(403, 'Unauthorized');
        }
        $rankings = $user->rankings;
        $userPosts = $user->posts;
        return view('users.admin.show', ['user'=>$user, 'rankings'=>$rankings, 'userPosts'=>$userPosts]);
    }

    // Block user as admin
    public function changeUserStatus(User $user){
        if (!Gate::allows('is-admin')) {
            abort(403, 'Unauthorized');
        }
        $currentStatus = $user->status;
        if($currentStatus === 'active'){
            $user->status = 'blocked';
        }else{
            $user->status = 'active';
        }
        $user->save();

        $message = [
            'content' => "Status użytkwnika został zmieniony",
            'type' => 'success'
        ];
        return back()->with('message', $message);
    }
}
