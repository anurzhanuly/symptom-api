<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireResource\Pages;
use App\Filament\Resources\QuestionnaireResource\RelationManagers;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireResource extends Resource
{
    protected static ?string $model = Questionnaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название опросника')
                    ->required(),

                Select::make('disease_id')
                    ->label('Заболевание')
                    ->relationship('disease', 'name') // меняй на нужный язык
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('questionnaire')
                    ->label('Вопросы')
                    ->columnSpanFull()
                    ->formatStateUsing(fn ($state) => json_encode(json_decode($state, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                    ->rows(10),

                Textarea::make('patient_card_options')
                    ->label('Настройки карты пациента')
                    ->columnSpanFull()
                    ->formatStateUsing(fn ($state) => json_encode(json_decode($state, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                    ->rows(10),

                Toggle::make('is_main')
                    ->label('Основной опросник'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('name')
                    ->label('Название'),

                TextColumn::make('disease.name')
                    ->label('Заболевание'),

                ToggleColumn::make('is_main')
                    ->label('Основной'),

                TextColumn::make('created_at')
                    ->label('Создан')
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
            'index' => Pages\ListQuestionnaires::route('/'),
            'create' => Pages\CreateQuestionnaire::route('/create'),
            'edit' => Pages\EditQuestionnaire::route('/{record}/edit'),
        ];
    }
}
