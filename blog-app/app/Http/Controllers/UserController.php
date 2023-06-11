<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller {
    // Show Register/Create Form
    public function create(){
        return view('users.register');
    }

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
    public function update(Request $request, User $user){
        if (auth()->user()->id === $user->id || auth()->user()->role === 'admin') {
            $formFields = $request->validate([
                'name'=>'required',
                'email'=>['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            ], [
                'name.required' => 'To pole jest wymagane.',
                'email.required' => 'Pole e-mail jest wymagane.',
                'email.email' => 'Pole e-mail musi być poprawnym adresem e-mail.',
                'email.unique' => 'Podany adres e-mail już istnieje w bazie danych.',
            ]);
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

    // Show Login Form
    public function login() {
        return view('users.login');
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
