<?php

namespace App\Traits\Models\Traits;

use App\Http\Filters\PostFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder, array $data): Builder
    {
        $ClassName =  'App\\Http\\Filters\\' . class_basename($this) . 'Filter';
        if (class_exists($ClassName)) {
            return (new $ClassName())->apply($data, $builder);
        }

        throw new \Exception("Filter method for model " . class_basename($this) . "not found: $ClassName" );






    }
}
