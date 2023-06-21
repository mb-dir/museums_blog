<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|max:255',
            'tags' => 'required|regex:/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]+(,\s[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]+)*$/',
            'content' => 'required|max:2000',
            'photo' => 'required|image|mimes:jpeg,png|max:300',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'To pole jest wymagane.',
            'title.max' => 'To pole może mieć :max znaków.',
            'tags.required' => 'To pole jest wymagane.',
            'tags.regex' => 'Pole tags ma nieprawidłowy format.',
            'content.required' => 'To pole jest wymagane.',
            'content.max' => 'To pole może mieć :max znaków.',
            'photo.required' => 'To pole jest wymagane.',
            'photo.image' => 'Wystąpił błąd podczas przesyłania pliku (dopuszczalne formaty to JPEG i PNG, maksymalny rozmiar to 300 kB).',
            'photo.mimes' => 'Wystąpił błąd podczas przesyłania pliku (dopuszczalne formaty to JPEG i PNG, maksymalny rozmiar to 300 kB).',
            'photo.max' => 'Wystąpił błąd podczas przesyłania pliku (dopuszczalne formaty to JPEG i PNG, maksymalny rozmiar to 300 kB).',
        ];
    }
}
