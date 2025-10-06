<?php

namespace Database\Factories;

use App\Models\Event;   // ✅ wichtig
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state. definition of fake data for each column in the events table
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'starts_at'   => fake()->dateTimeBetween('-30 days', '+60 days'),
            'location'    => fake()->city(),
            'description' => fake()->paragraph(),
            'title' => fake()->sentence(),
            'location' => fake()->city(),
            'content' => fake()->paragraphs(3, true),
        ];
    }

    // ensure host_id is set to a valid host user
    public function configure(): self
    {
    return $this->afterMaking(function (Event $event) {
        if (!$event->host_id) {
            // Versuche zufälligen Host zu nehmen …
            $hostId = User::where('role','host')->inRandomOrder()->value('id');
            // … falls noch keiner existiert (z. B. wenn jemand EventFactory vor Usern nutzt),
            // wird einer erstellt:
            if (!$hostId) {
                $hostId = User::factory()->host()->create()->id;
            }
            $event->host_id = $hostId;
        }
    });
    // afterCreating wäre auch ok; afterMaking + $event->host_id setzen, bevor insert passiert.
    }
}
