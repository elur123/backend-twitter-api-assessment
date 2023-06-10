<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Tweet extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'user_id',
        'content'
    ];

    /**
     * 
     * Relationship functions
     */

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files()
    {
        return $this->hasMany(TweetFile::class, 'tweet_id');
    }

    public function comments()
    {
        return $this->hasMany(TweetComment::class, 'tweet_id');
    }

    public function likes()
    {
        return $this->hasMany(TweetLike::class, 'tweet_id');
    }
}
