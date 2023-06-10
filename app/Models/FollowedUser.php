<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'followed_id'
    ];

    public $timestamps = false;

    /**
     * 
     * 
     * Relationship functions
     */

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
