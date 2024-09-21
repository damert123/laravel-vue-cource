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
            'username' => $this->profile['login'],
            'profile_id' => $this->profile_id,
            'category_id' => $this->category['title'],
            'image_path' => $this->image_path,
            'date' => $this->created_at->diffForHumans(),
            'status' => $this->status,
            'views' => $this->views,
            'like_count' => $this->likeable->count(),
            'comments_count' => $this->comments->count(),
            'tags' => TagResource::collection($this->tags)->resolve(),
//            'likes' => PostLikeResource::collection($this->likeable),
//            'comments' => CommentResource::collection($this->comments),
//            'tag' => TagResource::collection($this->tags),




        ];
    }
}
