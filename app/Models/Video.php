<?php

namespace App\Models;

use App\Traits\HasLogsEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    use HasLogsEvent;


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
