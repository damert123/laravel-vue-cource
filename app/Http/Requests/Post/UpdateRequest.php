<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date_format:Y-m-d',
            'profile_id' => 'required|integer',
            'category_id' => 'required|integer',
            'image_path' => 'nullable|string',
            'status' => 'nullable|integer',
            'views' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return[
            'title.required' => 'Ты забыл заполнить заголовок',
        ];

    }
}
