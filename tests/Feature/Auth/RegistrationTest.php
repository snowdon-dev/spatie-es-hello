<?php

namespace Tests\Feature\Auth;

use App\AggregateEvents\ProfileAggregate\ProfileCreated;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->hasInEventStream([
            'event_class' => ProfileCreated::class,
            'event_properties' => json_encode([
                'username' => 'Test User',
                'userId' => 1
            ])
        ]);
    }

    // @todo extract to base test
    protected function hasInEventStream(array $data)
    {
        $this->assertDatabaseHas('stored_events', $data);
    }
}
