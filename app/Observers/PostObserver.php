<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Post;
use App\Traits\HasLogsEvent;

class PostObserver
{


    public function created(Post $post)
    {
        $this->logEvent('created', null, $post->toArray(), $post);

    }


    public function updated(Post $post)
    {
        $this->logEvent('updated', $post->getOriginal(), $post->getDirty(), $post);
    }


    public function deleted(Post $post)
    {
        $this->logEvent('deleted', $post->toArray(), null, $post);
    }

    public function retrieved(Post $post)
    {
        $this->logEvent('retrieved', null, $post->toArray(), $post);
    }


    public function restored(Post $post): void
    {
        $this->logEvent('restored', null, $post->toArray(), $post);
    }


    public function forceDeleted(Post $post): void
    {
        //
    }


}
