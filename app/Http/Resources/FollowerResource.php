<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowerResource extends JsonResource
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
            'follower_id' => $this->follower_id,
            'followed_id' => $this->followed_id,
            'user' => [
                'id' => $this->follower->id,
                'uuid' => $this->follower->uuid,
                'name' => $this->follower->name,
                'username' => $this->follower->username,
                'email' => $this->follower->email
            ]
        ];
    }
}
