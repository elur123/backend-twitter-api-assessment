<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet_id',
        'like_by'
    ];

    public $timestamps = false;


    /**
     * 
     * 
     * Relationship functions
     */

    public function tweet()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id');
    }

    public function userLikeBy()
    {
        return $this->belongsTo(User::class, 'like_by');
    }
}
