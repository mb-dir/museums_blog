<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }

    public function show(){
         $rankings = Ranking::with('users')->get();
        return view('users.show', ['rankings'=>$rankings]);
    }

    // Create New User
    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['register_date'] = now();
        $formFields['score'] = 61;

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'Twoje konto zostało utworzone, zostałeś automatycznie zalogowany');
    }

    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Zostałeś wylogowany!');

    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Authenticate User
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Zostałeś poprawnie zalogowany!');
        }

        return back()->withErrors(['email' => 'Błędne dane'])->onlyInput('email');
    }
}
