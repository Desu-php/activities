<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use App\Helpers\PolygonHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateParticipant extends CreateRecord
{
    public function mutateFormDataBeforeCreate($data): array
    {
        $data['area'] = PolygonHelper::toPolygon($data['area']);

        return $data;
    }

    protected static string $resource = ParticipantResource::class;
}
