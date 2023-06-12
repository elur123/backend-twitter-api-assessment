<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetFileResource extends JsonResource
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
            'file_name' => $this->file_name,
            'file_url' => str_replace('public', 'storage', $this->file_url),
        ];
    }
}
