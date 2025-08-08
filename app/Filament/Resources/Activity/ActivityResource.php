<?php

namespace App\Filament\Resources\Activity;

use App\Enums\PermissionEnum;
use App\Filament\Resources\Activity\ActivityResource\Pages;
use App\Filament\Resources\Activity\ActivityResource\RelationManagers;
use App\Helpers\PolygonHelper;
use App\Models\Activity\Activity;
use App\Rules\GeoJsonCoordinatesCountRule;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITIES_READ);
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITIES_READ);
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITIES_CREATE);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITIES_UPDATE);
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITIES_DELETE);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('participant_id')
                    ->label('Участник')
                    ->relationship('participant', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('activity_type_id')
                    ->label('Тип активности')
                    ->relationship('activityType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->string()
                    ->maxLength(50),
                TextArea::make('description')
                    ->required()
                    ->string()
                    ->maxLength(800),
                FileUpload::make('media_file')
                    ->label('Медиа файл(картинка/видео)')
                    ->acceptedFileTypes([
                        'image/*',
                        'video/*',
                    ])
                    ->required()
                    ->maxSize(10024),
                TextArea::make('short_description')
                    ->required()
                    ->string()
                    ->maxLength(200),
                TextInput::make('registration_link')
                    ->required()
                    ->string()
                    ->maxLength(255)
                    ->url(),
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

                        $set('area', PolygonHelper::toField($record->area));
                    }),
                Repeater::make('activity_times')
                    ->label('Время активности')
                    ->schema([
                        DatePicker::make('date')
                            ->label('Дата')
                            ->required(),

                        TimePicker::make('time_from')
                            ->label('Время начала')
                            ->rules(function ($get) {
                                return [
                                    function ($attribute, $value, $fail) use ($get) {
                                        $timeTo = $get('time_to');

                                        if ($timeTo && $value > $timeTo) {
                                            $fail('Время начала не может быть позже времени окончания.');
                                        }
                                    }
                                ];
                            })
                            ->required(),

                        TimePicker::make('time_to')
                            ->label('Время окончания')
                            ->required(),
                    ])
                    ->addActionLabel('Добавить время')
                    ->required()
                    ->default([])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('activityType.name')
                    ->label('Тип активности')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('participant.name')
                    ->label('Участник')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Название')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('short_description')
                    ->label('Краткое описание')
                    ->limit(50),

                TextColumn::make('registration_link')
                    ->label('Ссылка')
                    ->url(fn ($record) => $record->registration_link, true)
                    ->openUrlInNewTab(),

                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
