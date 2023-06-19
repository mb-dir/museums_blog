<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
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
            'tags' => 'required|regex:/^[a-zA-Z]+(,\s[a-zA-Z]+)*$/',
            'content' => 'required|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'To pole jest wymagane.',
            'title.max' => 'To pole może mieć :max zmaków.',
            'tags.regex' => 'To pole ma nieprawidłowy format.',
            'tags.required' => 'To pole jest wymagane.',
            'content.required' => 'To pole jest wymagane.',
            'content.max' => 'To pole może mieć :max zmaków.',
        ];
    }
}
