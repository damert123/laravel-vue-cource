<?php

namespace App\Http\Requests\Comment;

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
            'title' => 'required|string|max:255',
            'post_id' => 'required|integer|exists:posts,id',
            'profile_id' => 'required|integer|exists:profiles,id',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ];
    }
}
