<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

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
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ], [
            'email.required' => 'Pole e-mail jest wymagane.',
            'email.email' => 'Pole e-mail musi być poprawnym adresem e-mail.',
            'password.required' => 'Pole hasło jest wymagane.',
        ]);

        if(auth()->attempt($formFields)) {
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
    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ], [
            'name.required' => 'To pole jest wymagane.',
            'name.min' => 'To pole musi mieć co najmniej :min znaki.',
            'email.required' => 'Pole e-mail jest wymagane.',
            'email.email' => 'Pole e-mail musi być poprawnym adresem e-mail.',
            'email.unique' => 'Podany adres e-mail już istnieje w bazie danych.',
            'password.required' => 'Pole hasło jest wymagane.',
            'password.confirmed' => 'Pole potwierdzenie hasła nie zgadza się z hasłem.',
            'password.min' => 'Pole hasło musi mieć co najmniej :min znaków.',
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['register_date'] = now();
        $formFields['score'] = 0;

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        $message = [
            'content' => "Twoje konto zostało utworzone, zostałeś automatycznie zalogowany",
            'type' => 'success'
        ];

        return redirect('/')->with('message', $message);
    }
}