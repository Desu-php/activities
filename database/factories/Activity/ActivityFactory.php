<?php

namespace Database\Factories\Activity;

use App\DTO\ActivityTimeDTO;
use App\Models\Activity\Activity;
use App\Models\Activity\ActivityType;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class ActivityFactory extends Factory
{

    protected $model = Activity::class;

    public function definition(): array
    {
        $points = [
            new Point(fake()->latitude(), fake()->longitude()),
            new Point(fake()->latitude(), fake()->longitude()),
            new Point(fake()->latitude(), fake()->longitude()),
            new Point(fake()->latitude(), fake()->longitude()),
        ];

        $points[] = $points[0];

        $timeTo = fake()->time();

        return [
            'activity_type_id' => ActivityType::factory(),
            'participant_id' => Participant::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraphs(3, true),
            'media_file' => fake()->imageUrl(800, 600, 'activities'),
            'short_description' => fake()->sentence(10),
            'registration_link' => fake()->url(),
            'area' => new Polygon([
                new LineString($points),
            ]),
            'activity_times' => [
                new ActivityTimeDTO(
                    date: fake()->date(),
                    time_from: fake()->time('H:i:s', $timeTo),
                    time_to: $timeTo,
                )
            ],
        ];
    }
}
