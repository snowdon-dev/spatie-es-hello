<?php

namespace Tests\Domain\Projectors;

use App\Aggregates\ProfileAggregate;
use App\Models\Profile;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class ProfileProjectorTest extends TestCase
{
    protected User $user;
    protected Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->profile = $this->createProfile();
    }

    // move to util
    private function createProfile()
    {
        $uuid = Str::uuid();

        $aggregate = ProfileAggregate::retrieve($uuid)
            ->createProfile("Dale Snowdon", $this->user->id)
            ->persist();

        return Profile::uuid($aggregate->uuid());
    }

    public function testCreate()
    {
        $this->assertDatabaseHas((new Profile())->getTable(), [
            'userId' => $this->user->id,
            'uuid' => $this->profile->uuid,
        ]);
    }

    public function test_change_username()
    {
        $this->assertEquals("Dale Snowdon", $this->profile->username);

        ProfileAggregate::retrieve($this->profile->uuid)
            ->updateUsername("Dale")
            ->persist();
        
        $this->profile->refresh();
        
        $this->assertEquals("Dale", $this->profile->username);
    }
}