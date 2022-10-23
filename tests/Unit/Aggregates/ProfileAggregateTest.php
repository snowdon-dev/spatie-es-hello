<?php

namespace Tests\Unit\Aggregates;

use App\AggregateEvents\ProfileAggregate\ProfileCreated;
use App\AggregateEvents\ProfileAggregate\UsernameChanged;
use App\Aggregates\ProfileAggregate;
use Tests\TestCase;

class ProfileAggregateTest extends TestCase 
{
    private static $START_USER = ['username' => 'Dale'];

    public function provideChangingUsername()
    {
        return [
            ["41a90da0-975e-4eec-937b-9e070cafe6a9", self::$START_USER, 'Dale Snowdon'],
            ["41a90da0-975e-4eec-937b-9e070cafe6a8", self::$START_USER, 'Explict word here Snowdon'],
        ];
    }

    /**
     * @dataProvider provideChangingUsername
     */
    public function testChangingUsername(string $uuid, array $startUser, string $expectedUsername)
    {
        \Spatie\EventSourcing\Facades\Projectionist::withoutEventHandlers();
        $tmpEvent = new UsernameChanged($expectedUsername);
        ProfileAggregate::fake($uuid)
            ->given($this->createProfileStreamOf($startUser))
            ->when(fn (ProfileAggregate $a) => $a->updateUsername($expectedUsername))
            ->assertRecorded(new UsernameChanged($expectedUsername))
            ->assertApplied($this->createProfileStreamOf($startUser, $tmpEvent));
    }

    private function createProfileStreamOf(array $user, ...$events)
    {
        $username = $user['username'] ?? 'Random Name';
        $userId = $user['userId'] ?? 1;
        return [new ProfileCreated($username, $userId), ...$events];
    }
}