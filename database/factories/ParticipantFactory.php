<?php

namespace Database\Factories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

/**
 * @extends Factory<Participant>
 */
class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        $points = [
            new Point(fake()->latitude(), fake()->longitude()),
            new Point(fake()->latitude(), fake()->longitude()),
            new Point(fake()->latitude(), fake()->longitude()),
            new Point(fake()->latitude(), fake()->longitude()),
        ];

        $points[] = $points[0];

        return [
            'name' => fake()->company(),
            'site_url' => fake()->url(),
            'logo' => fake()->imageUrl(300, 300, 'logo'),
            'area' => new Polygon([
                new LineString($points),
            ]),
        ];
    }
}
