<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiseaseResource\Pages;
use App\Filament\Resources\DiseaseResource\RelationManagers;
use App\Models\Disease;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiseaseResource extends Resource
{
    protected static ?string $model = Disease::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Казахский')
                    ->schema([
                        TextInput::make('name_kk')
                            ->label('Название (Каз)')
                            ->required(),
                        Textarea::make('description_kk')
                            ->label('Описание (Каз)'),
                    ]),
                Section::make('Русский')
                    ->schema([
                        TextInput::make('name_ru')
                            ->label('Название (Рус)')
                            ->required(),
                        Textarea::make('description_ru')
                            ->label('Описание (Рус)'),
                    ]),
                Section::make('Английский')
                    ->schema([
                        TextInput::make('name_en')
                            ->label('Название (Анг)')
                            ->required(),
                        Textarea::make('description_en')
                            ->label('Описание (Анг)'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Название'),
                TextColumn::make('name_kk')->label('Название (Каз)'),
                TextColumn::make('name_ru')->label('Название (Рус)'),
                TextColumn::make('name_en')->label('Название (Анг)'),
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
            'index' => Pages\ListDiseases::route('/'),
            'create' => Pages\CreateDisease::route('/create'),
            'edit' => Pages\EditDisease::route('/{record}/edit'),
        ];
    }
}
