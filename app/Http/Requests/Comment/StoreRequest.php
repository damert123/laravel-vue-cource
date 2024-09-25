<?php

namespace App\Http\Requests\Comment;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            'parent_id' => 'nullable|integer|exists:comments,id',
//            'commentable_type' => 'required|string|in:video,post',
//            'commentable_id' => 'required|integer|exists:comments,id',
        ];
    }

    protected function passedValidation()
    {
        $commentableType = match($this->input('commentable_type')){
            'posts' => (new Post())->getMorphClass(),
            'videos' => (new Video())->getMorphClass(),
            default => null
        };

        if (!$commentableType) {
            throw ValidationException::withMessages([
               'commentable_type' => 'Не выбран тип комментария',
            ]);
        }

        $commentableId = $this->input('commentable_id');
        if (!$commentableId) {
            throw ValidationException::withMessages([
                'commentable_id' => 'Выберете что-то из списка',
            ]);
        }


        return $this->merge([
            'profile_id' => auth()->user()->profile->id,
             'commentable_type' => $commentableType,  // преобразование в правильный тип модели
        ]);
    }
}
