<?php

namespace App\AggregateEvents\ProfileAggregate;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProfileCreated extends ShouldBeStored
{
    public string $username;
    public int $userId;
    public function __construct(string $username, int $userId)
    { 
        $this->username = $username;
        $this->userId = $userId;
    }
}