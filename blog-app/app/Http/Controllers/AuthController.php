<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function login()
    {
        return view('users.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $message = [
            'content' => "Zostałeś wylogowany",
            'type' => 'info'
        ];

        return redirect('/')->with('message', $message);
    }

    public function authenticate(AuthRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $message = [
                'content' => "Zostałeś poprawnie zalogowany!",
                'type' => 'success'
            ];

            return redirect('/')->with('message', $message);
        }

        return back()->withErrors(['email' => 'Błędne dane'])->onlyInput('email');
    }

    public function store(CreateUserRequest $request)
    {
        $formFields = $request->validated();

        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['register_date'] = now();

        $user = User::create($formFields);

        Auth::login($user);

        $message = [
            'content' => "Twoje konto zostało utworzone, zostałeś automatycznie zalogowany",
            'type' => 'success'
        ];

        return redirect('/')->with('message', $message);
    }
}
