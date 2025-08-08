<?php

namespace App\Helpers;

use MatanYadaev\EloquentSpatial\Enums\Srid;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class PolygonHelper
{
    public static function toPolygon(array $points): Polygon
    {
        return new Polygon([
            new LineString(
                array_map(
                    fn(array $poin) => new Point($poin[1], $poin[0]),
                    $points['geojson']['features'][0]['geometry']['coordinates'][0]
                )
            ),
        ], Srid::WGS84->value);
    }

    public static function toField(Polygon $polygon): array
    {
        $rawRings = $polygon->getCoordinates();

        $firstPoint = $rawRings[0][0];

        return [
            'lat' => $firstPoint[1],
            'lng' => $firstPoint[0],
            'geojson' => [
                'type' => 'FeatureCollection',
                'features' => [
                    [
                        'type' => 'Feature',
                        'properties' => [],
                        'geometry' => [
                            'type' => 'Polygon',
                            'coordinates' => $rawRings,
                        ],
                    ],
                ],
            ],
        ];
    }
}
