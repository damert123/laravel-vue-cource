<?php

namespace App\Http\Filters;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CommentFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'content',
        'created_at_from',
        'created_at_to',
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

    protected function createdAtFrom(Builder $query, $value)
    {
        $query->whereDate('created_at', '>=', $value);

    }

    protected function createdAtTo(Builder $query, $value)
    {
        $query->whereDate('created_at', '<=', $value);
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



