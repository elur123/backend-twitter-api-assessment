<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet_id',
        'file_name',
        'file_url',
    ];


    /**
     * 
     * Relationship functions
     */

    public function tweet()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id');
    }
}
