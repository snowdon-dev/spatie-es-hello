<?php

namespace App\Projectors;

use App\AggregateEvents\ProfileAggregate\ProfileCreated;
use App\AggregateEvents\ProfileAggregate\UsernameChanged;
use App\Models\Profile;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class ProfileProjector extends Projector
{
    public function onProfileCreated(ProfileCreated $event)
    {
        Profile::create([
            'uuid' => $event->aggregateRootUuid(),
            'username' => $event->username,
            'userId' => $event->userId,
        ]);
    }

    public function onUsernameChanged(UsernameChanged $event)
    {
        $profile = Profile::uuid($event->aggregateRootUuid());
        $profile->username = $event->username;
        $profile->save();
    }

    // delete.. etc
}
