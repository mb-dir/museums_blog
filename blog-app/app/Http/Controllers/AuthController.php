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

    // Show Register/Create Form
    public function create(){
        return view('users.register');
    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $message = [
            'content' => "Zostałeś wylogowany",
            'type' => 'info'
        ];

        return redirect('/')->with('message', $message);
    }

    // Authenticate User
    public function authenticate(AuthRequest $request) {
        $formFields = $request->validated();

        if(Auth::attempt($formFields)) {
            $request->session()->regenerate();

            $message = [
                'content' => "Zostałeś poprawnie zalogowany!",
                'type' => 'success'
            ];

            return redirect('/')->with('message', $message);
        }

        return back()->withErrors(['email' => 'Błędne dane'])->onlyInput('email');
    }

    // Create New User
    public function store(CreateUserRequest $request) {
        $formFields = $request->validated();

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['register_date'] = now();

        // Create User
        $user = User::create($formFields);

        // Login
        Auth::login($user);

        $message = [
            'content' => "Twoje konto zostało utworzone, zostałeś automatycznie zalogowany",
            'type' => 'success'
        ];

        return redirect('/')->with('message', $message);
    }
}
