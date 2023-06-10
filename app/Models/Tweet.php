<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

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
}
