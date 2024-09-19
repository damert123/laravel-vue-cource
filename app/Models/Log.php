<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';


//    protected $casts = [
//        'old_values' => 'array',
//        'new_values' => 'array',
//    ];
}
