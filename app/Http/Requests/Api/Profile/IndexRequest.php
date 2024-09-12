<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'birthed_at_from' => ['nullable', 'date:Y-m-d'],
            'birthed_at_to' => ['nullable', 'date:Y-m-d'],
            'city' => ['nullable', 'string'],
            'about' => ['nullable', 'string'],
            'login' => ['nullable', 'string'],







        ];
    }
}
