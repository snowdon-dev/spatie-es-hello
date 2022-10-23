<?php

namespace App\AggregateEvents\ProfileAggregate;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UsernameChanged extends ShouldBeStored
{
    public string $username;

    public function __construct(string $username)
    {
        $this->username = $username;        
    }
}