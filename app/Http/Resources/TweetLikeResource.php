<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetLikeResource extends JsonResource
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
            'tweet_id' => $this->tweet_id,
            'like_by' => $this->like_by,
            'user' => [
                'id' => $this->userLikeBy->id,
                'uuid' => $this->userLikeBy->uuid,
                'name' => $this->userLikeBy->name,
                'username' => $this->userLikeBy->username,
                'email' => $this->userLikeBy->email
            ]
        ];
    }
}
