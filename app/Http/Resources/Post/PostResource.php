<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'profile_id' => $this->profile_id,
            'category_id' => $this->category_id,
            'image_path' => $this->image_path,
            'status' => $this->status,
            'views' => $this->views,
            'likes' => PostLikeResource::collection($this->likeable),
            'comments' => CommentResource::collection($this->comments),
            'tag' => TagResource::collection($this->tags),




        ];
    }
}
