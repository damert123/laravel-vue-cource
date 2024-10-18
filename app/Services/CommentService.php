<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;

class CommentService
{

    public static function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public static function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        return $comment;

    }

    public static function delete(Comment $comment): void
    {
        if ($comment->replies()->exists()){
            $comment->replies()->delete();
        }
        $comment->delete();

    }

}
