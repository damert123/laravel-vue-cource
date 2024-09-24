<?php

namespace App\Models;

use App\Traits\HasLogsEvent;
use App\Traits\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFilter;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'profile_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->hasManyThrough(Category::class, Post::class);
    }

//    public function profileable()
//    {
//        return $this->morphTo('profileable');
//    }

    public function likedPosts()
    {
        return $this->morphedByMany(Post::class, 'likeable');
    }
    public function likedComments()
    {
        return $this->morphedByMany(Comment::class, 'likeable');
    }






//    public function likedPosts()
//    {
//        return $this->belongsToMany(Post::class, 'liked_posts', 'profile_id', 'post_id');
//    }


}
