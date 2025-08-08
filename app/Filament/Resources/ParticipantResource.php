<?php

namespace App\Filament\Resources;

use App\Enums\PermissionEnum;
use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Filament\Resources\ParticipantResource\RelationManagers\ActivitiesRelationManager;
use App\Helpers\PolygonHelper;
use App\Models\Participant;
use App\Rules\GeoJsonCoordinatesCountRule;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()->can(PermissionEnum::PARTICIPANTS_READ);
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::PARTICIPANTS_READ);
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can(PermissionEnum::PARTICIPANTS_CREATE);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::PARTICIPANTS_UPDATE);
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::PARTICIPANTS_DELETE);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название участника')
                    ->required()
                    ->maxLength(255),

                TextInput::make('site_url')
                    ->label('Сайт')
                    ->url()
                    ->required()
                    ->maxLength(255),

                FileUpload::make('logo')
                    ->label('Логотип')
                    ->image()
                    ->required()
                    ->maxSize(1024),

                Map::make('area')
                    ->geoMan()
                    ->drawPolygon(true)
                    ->drawCircle(false)
                    ->drawCircleMarker(false)
                    ->drawMarker(false)
                    ->drawPolyline(false)
                    ->drawRectangle(false)
                    ->drawText(false)
                    ->editPolygon(true)
                    ->deleteLayer(true)
                    ->rules([
                        new GeoJsonCoordinatesCountRule()
                    ])
                    ->afterStateHydrated(function ($state, $record, Set $set): void {
                        if (!$record) {
                            return;
                        }

                        $set('area', PolygonHelper::toField( $record->area));
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('logo')
                    ->label('Картинка')
                    ->circular()
                    ->height(40),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('site_url')
                    ->label('Сайт')
                    ->url(fn($record) => $record->site_url),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ActivitiesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
