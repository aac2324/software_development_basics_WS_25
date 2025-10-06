<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
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
        ];
    }
}
