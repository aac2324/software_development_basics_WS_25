<?php

namespace Database\Factories;

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
}
