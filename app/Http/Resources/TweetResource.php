<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TweetFileResource;
use App\Http\Resources\TweetCommentResource;
use App\Http\Resources\TweetLikeResource;
class TweetResource extends JsonResource
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
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'author' => [
                'id' => $this->author->id,
                'uuid' => $this->author->uuid,
                'name' => $this->author->name,
                'username' => $this->author->username,
                'email' => $this->author->email
            ],
            'files' => TweetFileResource::collection($this->files),
            'comments' => TweetCommentResource::collection($this->comments),
            'likes' => TweetLikeResource::collection($this->likes),
            'created_at' => date("F j, Y, g:i a", strtotime($this->created_at)),
            'updated_at' => date("F j, Y, g:i a", strtotime($this->updated_at)),
        ];
    }
}
