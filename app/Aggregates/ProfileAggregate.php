<?php

namespace App\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

use App\AggregateEvents\ProfileAggregate\{ProfileCreated,UsernameChanged};

class ProfileAggregate extends AggregateRoot
{
    private ?string $username;

    public function createProfile(string $name, int $userId)
    {
        $this->recordThat(new ProfileCreated($name, $userId));
        return $this;
    }
    public function updateUsername(string $name)
    {
        $this->recordThat(new UsernameChanged($name));
        return $this;
    }
    public function applyUpdateUsername(UsernameChanged $event)
    {
        $this->username = $event->username;
    }
}
