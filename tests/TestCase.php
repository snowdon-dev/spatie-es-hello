<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function hasInEventStream(array $data)
    {
        $this->assertDatabaseHas('stored_events', $data);
    }
}
