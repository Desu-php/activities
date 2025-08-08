<?php

namespace App\Filament\Resources\ParticipantResource\RelationManagers;

use App\Filament\Resources\Activity\ActivityResource\ActivityResourceSchema;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return ActivityResourceSchema::form($form);
    }

    public function table(Table $table): Table
    {
        return ActivityResourceSchema::table($table);
    }
}
