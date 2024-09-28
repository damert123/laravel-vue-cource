<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function prepareForValidation()
    {
        if ($this->hasFile('image')){
            $this->merge([
                'image_path' => $this->file('image')->store('images', 'public')
            ]);
        }
    }



    public function rules(): array
    {

        return [
            'title' => 'required|string|min:10|max:100',
            'content' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'published_at' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:' . now()->subMonths(6)->toDateString(),
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];

    }



//    public function messages()
//    {
//       return[
//           'title.required' => 'Поле "Заголовок" обязательно для заполнения.',
//           'title.string' => 'Поле "Заголовок" должно быть строкой.',
//           'title.min' => 'Поле "Заголовок" должно содержать минимум 10 символов.',
//           'title.max' => 'Поле "Заголовок" не должно превышать 100 символов.',
//
//           'content.required' => 'Поле "Содержание" обязательно для заполнения.',
//           'content.string' => 'Поле "Содержание" должно быть строкой.',
//           'content.max' => 'Поле "Содержание" не должно превышать 255 символов.',
//
//           'category_id.required' => 'Поле "Категория" обязательно для заполнения.',
//           'category_id.integer' => 'Поле "Категория" должно быть числом.',
//           'category_id.exists' => 'Выбранная категория не существует.',
//
//           'published_at.required' => 'Поле "Дата публикации" обязательно для заполнения.',
//           'published_at.date_format' => 'Поле "Дата публикации" должно быть в формате дд-мм-гггг.',
//           'published_at.before_or_equal' => 'Поле "Дата публикации" не может быть в будущем.',
//           'published_at.after_or_equal' => 'Поле "Дата публикации" не может быть ранее, чем полгода назад.',
//
//       ];
//    }

    protected function passedValidation()
    {

        $this->merge([
            'profile_id' => auth()->user()->profile->id
        ]);






    }
}
