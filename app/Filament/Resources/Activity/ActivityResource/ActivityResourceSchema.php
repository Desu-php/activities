<?php

namespace App\Filament\Resources\Activity\ActivityResource;

use App\Filament\Resources\Activity\ActivityResource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class ActivityResourceSchema
{
    public static function form(Form $form): Form
    {
        return ActivityResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ActivityResource::table($table);
    }
}
