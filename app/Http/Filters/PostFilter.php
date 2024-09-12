<?php

namespace App\Http\Filters;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'content',
        'published_at_from',
        'published_at_to',
        'category_title',
        'status',
    ];


    protected function title(Builder $query, $value)
    {

        $query->where('title', 'ilike', "%$value%");
    }

    protected function content(Builder $query, $value)
    {

        $query->where('content', 'ilike', "%$value%");
    }

    protected function publishedAtFrom(Builder $query, $value)
    {
        $query->whereDate('published_at', '>=', $value);

    }

    protected function publishedAtTo(Builder $query, $value)
    {
        $query->whereDate('published_at', '<=', $value);
    }



    protected function status(Builder $query, $value)
    {
        $query->where('status', $value);

    }

    protected function categoryTitle(Builder $query, $value)
    {
        $query->whereRelation('category', 'title', 'ilike',  "%$value%");
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



