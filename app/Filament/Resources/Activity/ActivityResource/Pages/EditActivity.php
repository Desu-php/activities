<?php

namespace App\Filament\Resources\Activity\ActivityResource\Pages;

use App\DTO\ActivityTimeDTO;
use App\Filament\Resources\Activity\ActivityResource;
use App\Helpers\PolygonHelper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivity extends EditRecord
{
    protected static string $resource = ActivityResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
