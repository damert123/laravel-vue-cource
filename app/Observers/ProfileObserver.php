<?php

namespace App\Observers;

use App\Models\Profile;
use App\Traits\HasLogsEvent;

class ProfileObserver
{


    public function created(Profile $profile): void
    {
        $this->logEvent('created', null, $profile->toArray(), $profile);
    }

    public function updated(Profile $profile): void
    {
        $this->logEvent('updated', $profile->getOriginal(), $profile->getDirty(), $profile);
    }
    public function deleted(Profile $profile): void
    {
        $this->logEvent('deleted', $profile->toArray(), null, $profile);
    }

    public function retrieved(Profile $profile)
    {
        $this->logEvent('retrieved', null, $profile->toArray(), $profile);
    }

    public function restored(Profile $profile): void
    {
        $this->logEvent('restored', null, $profile->toArray(), $profile);
    }

    public function forceDeleted(Profile $profile): void
    {
        //
    }
}
