<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilePostLike extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'profile_post_like';



}
