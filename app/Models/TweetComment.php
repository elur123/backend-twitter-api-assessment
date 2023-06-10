<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet_id',
        'comment_by',
        'comment'
    ];

    /**
     * 
     * 
     * Relationship functions
     */

     public function tweet()
     {
         return $this->belongsTo(Tweet::class, 'tweet_id');
     }
 
     public function userCommentBy()
     {
         return $this->belongsTo(User::class, 'comment_by');
     }
}
