<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetCommentResource extends JsonResource
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
            'comment_by' => $this->comment_by,
            'comment' => $this->comment,
            'user' => [
                'id' => $this->userCommentBy->id,
                'uuid' => $this->userCommentBy->uuid,
                'name' => $this->userCommentBy->name,
                'username' => $this->userCommentBy->username,
                'email' => $this->userCommentBy->email
            ]
        ];
    }
}
