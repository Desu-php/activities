<?php

namespace App\Filament\Resources\Activity;

use App\Enums\PermissionEnum;
use App\Filament\Resources\Activity\ActivityTypeResource\Pages;
use App\Filament\Resources\Activity\ActivityTypeResource\RelationManagers;
use App\Models\Activity\ActivityType;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityTypeResource extends Resource
{
    protected static ?string $model = ActivityType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITY_TYPE_READ);
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITY_TYPE_READ);
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITY_TYPE_CREATE);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITY_TYPE_UPDATE);
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can(PermissionEnum::ACTIVITY_TYPE_DELETE);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sort')
                    ->label('Порядок')
                    ->required()
                    ->integer()
                    ->minValue(0),
                FileUpload::make('image')
                    ->label('Картинка')
                    ->image()
                    ->maxSize(1024)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('image')
                    ->label('Картинка')
                    ->circular()
                    ->height(40),
                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sort')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListActivityTypes::route('/'),
            'create' => Pages\CreateActivityType::route('/create'),
            'edit' => Pages\EditActivityType::route('/{record}/edit'),
        ];
    }
}
