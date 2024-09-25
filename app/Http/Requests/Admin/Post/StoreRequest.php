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
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:100',
            'content' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    protected function passedValidation()
    {
        return $this->merge([
            'profile_id' => auth()->user()->profile->id
        ]);
    }
}
