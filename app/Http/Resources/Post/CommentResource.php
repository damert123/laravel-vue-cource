<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $replayName = isset ($this->parent) ? $this->parent->profile->login : null;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'post_id' => $this->commentable_id,
            'username' => $this->profile['login'],
            'replyName' => $replayName,
            'parent_id' => $this->parent_id,
            'replies' => CommentResource::collection($this->replies),
            'created_at' => $this->created_at->diffForHumans(),
            'showReplies' => false
        ];
    }
}
