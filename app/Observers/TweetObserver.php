<?php

namespace App\Observers;

use App\Models\Tweet;

class TweetObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(Tweet $tweet): void
    {
        //
    }
}
