<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }
        $users = User::where('role', 'user')->get();
        return view('users.admin.index', compact('users'));
    }

    public function show(User $user)
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }
        $rankings = $user->rankings;
        $userPosts = $user->posts;
        return view('users.admin.show', compact('user', 'rankings', 'userPosts'));
    }
}
