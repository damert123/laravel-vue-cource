<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|min:3|max:50',
            'login' => 'required|string|min:3|max:50|unique:profiles,login|regex:/^[a-zA-Z0-9_-]+$/',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email обязателен',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Такой email уже есть.',
            'password.required' => 'Пароль обязателен.',
            'password.min' => 'Пароль должен быть не менее 8 символов.',
            'name.required' => 'Имя обязательно.',
            'name.min' => 'Имя должно быть не менее 3 символов.',
            'name.max' => 'Имя должно быть не более 50 символов.',
            'login.required' => 'Заполните логин',
            'login.unique' => 'Такой логин уже занят',
            'login.min' => 'Логин должен быть минимум 3 символа',
            'login.max' => 'Логин привышает 50 символов',
            'login.regex' => 'Логин разрешает только латинские буквы'
        ];

    }
}
