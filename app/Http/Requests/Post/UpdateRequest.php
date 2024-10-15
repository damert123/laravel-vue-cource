<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {

        if ($this->hasFile('post.image')){

            $this->merge([
                'post' => [
                    ...$this->input('post'),
                    'image_path' => $this->file('post.image')->store('images', 'public')
                ]

            ]);
        }



    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [

            'post.title' => 'required|string|min:10|max:100',
            'post.content' => 'required|string|max:255',
            'post.category_id' => 'required|integer|exists:categories,id',
            'post.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'post.published_at' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:' . now()->subMonths(6)->toDateString(),
            ],
            'tags' => 'nullable|string',


        ];

    }

    public function messages()
    {
        return[
            'title.required' => 'Ты забыл заполнить заголовок',
        ];

    }


}
