<?php

namespace App\Models;

use App\Http\Filters\PostFilter;
use App\Traits\HasLogsEvent;
use App\Traits\HasLogsEventToFile;
use App\Traits\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class Post extends Model
{
    use HasFactory;
//    use SoftDeletes;
    use HasLogsEventToFile;
    use HasFilter;

    protected $table = 'posts';

//    protected static function booted()
//    {
//
//
//        static::created(function (Model $model) {
//
//            \Illuminate\Support\Facades\Log::info('Custom logic for Post creation: ' . $model->id);
//        });
//
//    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');

    }

    public function likedByProfiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_post_like', 'post_id', 'profile_id');
    }

    public function getImageUrlAttribute():string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : '';
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');

    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likeable()
    {
        return $this->morphToMany(Profile::class, 'likeable');
    }






}
