<?php

namespace App\Models;

use App\Traits\HasLogsEvent;
use App\Traits\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasLogsEvent;
    use HasFilter;

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function category()
    {
        return $this->post->category();
    }

    public function commentable()
    {
        return $this->morphTo();
    }


    public function likeable()
    {
        return $this->morphToMany(Profile::class, 'likeable');
    }




}
