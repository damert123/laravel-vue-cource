<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observer extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}
