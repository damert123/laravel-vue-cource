<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'birthed_at' => $this->birthed_at,
            'role' => $this->role,
            'status' => $this->status,
            'city' => $this->city,
            'about' => $this->about,
            'login' => $this->login,
            'avatar_path' => $this->avatar_path,

        ];
    }
}
