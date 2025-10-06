<?php

use App\Models\Event;
use App\Models\User;

it('shows the latest 2 events on the welcome page', function () {
    // Arrange: create hosts and 3 events
    User::factory(10)->create();

    $first  = Event::factory()->create(['created_at' => now()->subDays(2)]);
    $second = Event::factory()->create(['created_at' => now()->subDay()]);
    $third  = Event::factory()->create(['created_at' => now()]);

    // Act: visit the welcome page
    $response = $this->get('/');

    // Assert: page is successful
    $response->assertOk();

    // Assert: latest two events are visible
    $response->assertSee($third->title);
    $response->assertSee($second->title);

    // Assert: oldest event is not visible
    $response->assertDontSee($first->title);
});
