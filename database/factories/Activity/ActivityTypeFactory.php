<?php

namespace Database\Factories\Activity;

use App\Models\Activity\ActivityType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityType>
 */
class ActivityTypeFactory extends Factory
{
    protected $model = ActivityType::class;

    public function definition(): array
    {
        return [
            'name'  => fake()->words(2, true),
            'image' => fake()->imageUrl(640, 480, 'activities'),
            'sort'  => fake()->numberBetween(1, 100),
        ];
    }
}
