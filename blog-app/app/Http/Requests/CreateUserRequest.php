<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'To pole jest wymagane.',
            'name.min' => 'To pole musi mieć co najmniej :min znaki.',
            'name.min' => 'To pole może mieć co najwyżej :max znaków.',
            'email.required' => 'Pole e-mail jest wymagane.',
            'email.email' => 'Pole e-mail musi być poprawnym adresem e-mail.',
            'email.unique' => 'Podany adres e-mail już istnieje w bazie danych.',
            'password.required' => 'Pole hasło jest wymagane.',
            'password.confirmed' => 'Pole potwierdzenie hasła nie zgadza się z hasłem.',
            'password.min' => 'Pole hasło musi mieć co najmniej :min znaków.',
        ];
    }
}
