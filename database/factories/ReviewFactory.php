<?php
namespace Database\Factories;

use App\Models\User;   // ✅ Import
use App\Models\Event;  // ✅ Import
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => fake()->numberBetween(1,10), 
            'host' => fake()->name(),
            'user_id'  => User::inRandomOrder()->value('id') ?? User::factory(), // ✅ new
            'rating'   => $this->faker->numberBetween(1,5), // ✅ new
            'content' => fake()->text(),
        ];
    }
}
