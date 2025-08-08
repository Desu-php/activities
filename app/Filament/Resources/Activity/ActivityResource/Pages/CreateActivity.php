<?php

namespace App\Filament\Resources\Activity\ActivityResource\Pages;

use App\DTO\ActivityTimeDTO;
use App\Filament\Resources\Activity\ActivityResource;
use App\Helpers\PolygonHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

    public function mutateFormDataBeforeCreate($data): array
    {
        $data['activity_times'] = array_map(
            fn(array $time) => new ActivityTimeDTO(
                date: $time['date'],
                time_from: $time['time_from'],
                time_to: $time['time_to']
            ),
            $data['activity_times']
        );

        $data['area'] = PolygonHelper::toPolygon($data['area']);

        return $data;
    }
}
