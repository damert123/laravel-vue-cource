<?php

namespace App\Http\Filters;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProfileFilter extends AbstractFilter
{
    protected array $keys = [
        'birthed_at_from',
        'birthed_at_to',
        'city',
        'about',
        'login',
    ];


    protected function city(Builder $query, $value)
    {

        $query->where('city', 'ilike', "%$value%");
    }

    protected function about(Builder $query, $value)
    {

        $query->where('about', 'ilike', "%$value%");
    }

    protected function birthedAtFrom(Builder $query, $value)
    {
        $query->whereDate('birthed_at', '>=', $value);

    }

    protected function birthedAtTo(Builder $query, $value)
    {
        $query->whereDate('birthed_at', '<=', $value);
    }

    protected function login(Builder $query, $value)
    {

        $query->where('login', 'ilike', "%$value%");
    }



}




//    if (isset($data['published_at_from']) && isset($data['published_at_to'])) {
//
//        $query->whereBetween('published_at', [$data['published_at_from'], $data['published_at_to']]);
//    }
//
//    if (isset($data['published_at_to'])) {
//        $query->whereDate('published_at', '<=', $data['published_at_to']);
//    }



