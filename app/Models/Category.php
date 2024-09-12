<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }

    public function comment()
    {
        return $this->hasOneThrough(Comment::class, Post::class)->latest();
    }

//    public function profilePostLikes_count()
//    {
//        return $this->posts()
//            ->join('profile_post_like', 'posts.id', '=', 'profile_post_like.post_id')
//            ->count('profile_post_like.id');
//    }

    public function profilePostLikes()
    {
        return $this->hasManyThrough(ProfilePostLike::class, Post::class);
    }

    public function likesCategoryCount()
    {
        return $this->profilePostLikes()->count();
    }

    //ВОПРОСЫ Пришлось создать модель для пивотной таблицы, нормальная практика ?))


}
