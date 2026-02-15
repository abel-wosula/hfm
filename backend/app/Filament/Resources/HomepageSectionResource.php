<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSectionResource\Pages;
use App\Filament\Resources\HomepageSectionResource\RelationManagers;
use App\Models\HomepageSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('key')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('type')
                ->default('custom')
                ->required(),

            Forms\Components\TextInput::make('title')
                ->required(),

            Forms\Components\TextInput::make('subtitle'),

            Forms\Components\Textarea::make('content'),

            Forms\Components\ColorPicker::make('background_color'),

            Forms\Components\Select::make('text_align')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ]),

            Forms\Components\TextInput::make('button_text'),
            Forms\Components\TextInput::make('button_link'),

            Forms\Components\TextInput::make('button_secondary_text'),
            Forms\Components\TextInput::make('button_secondary_link'),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->default(true),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('subtitle')
                    ->limit(30),

                Tables\Columns\TextColumn::make('content')
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('button_text')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('button_link')
                    ->url(fn($record) => $record->button_link, true)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('button_secondary_text')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('button_secondary_link')
                    ->url(fn($record) => $record->button_secondary_link, true)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\ColorColumn::make('background_color'),

                Tables\Columns\TextColumn::make('text_align')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListHomepageSections::route('/'),
            'create' => Pages\CreateHomepageSection::route('/create'),
            'edit' => Pages\EditHomepageSection::route('/{record}/edit'),
        ];
    }
}
