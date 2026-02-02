<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UploadRecordResource\Pages;
use App\Models\UploadRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class UploadRecordResource extends Resource
{
    protected static ?string $model = UploadRecord::class;
    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Music Uploads';
    protected static ?string $modelLabel = 'Music Upload';
    protected static ?string $pluralModelLabel = 'Music Uploads';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('music_title')
                    ->label('Music Title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('composer')
                    ->label('Composer')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('youtube_link')
                    ->label('YouTube Link')
                    ->url()
                    ->maxLength(500)
                    ->placeholder('https://www.youtube.com/watch?v=... or https://youtu.be/...')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('file_path')
                    ->label('File Upload')
                    ->directory('upload-records/files')
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'text/plain',
                        'image/jpeg',
                        'image/png',
                    ])
                    ->maxSize(5120) // 5MB
                    ->helperText('Accepted: PDF, Word, Text, Images. Max 5MB')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('audio_path')
                    ->label('Audio File')
                    ->directory('upload-records/audio')
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->acceptedFileTypes([
                        'audio/mpeg',
                        'audio/mp3',
                        'audio/wav',
                        'audio/ogg',
                        'audio/m4a',
                    ])
                    ->maxSize(10240) // 10MB
                    ->helperText('Accepted: MP3, WAV, OGG, M4A. Max 10MB')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('message')
                    ->label('Message/Notes')
                    ->rows(4)
                    ->maxLength(1000)
                    ->placeholder('Any additional notes or messages...')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('music_title')
                    ->label('Music Title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('composer')
                    ->label('Composer')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('youtube_link')
                    ->label('YouTube')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'gray')
                    ->sortable(),

                Tables\Columns\IconColumn::make('file_path')
                    ->label('File')
                    ->boolean()
                    ->trueIcon('heroicon-o-document')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\IconColumn::make('audio_path')
                    ->label('Audio')
                    ->boolean()
                    ->trueIcon('heroicon-o-speaker-wave')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_youtube_link')
                    ->label('Has YouTube Link')
                    ->query(fn($query) => $query->whereNotNull('youtube_link'))
                    ->toggle(),

                Tables\Filters\Filter::make('has_file')
                    ->label('Has File')
                    ->query(fn($query) => $query->whereNotNull('file_path'))
                    ->toggle(),

                Tables\Filters\Filter::make('has_audio')
                    ->label('Has Audio')
                    ->query(fn($query) => $query->whereNotNull('audio_path'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_file')
                    ->label('Download File')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (UploadRecord $record) {
                        return response()->download(
                            storage_path('app/public/' . $record->file_path)
                        );
                    })
                    ->visible(fn(UploadRecord $record) => !empty($record->file_path)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUploadRecords::route('/'),
            'create' => Pages\CreateUploadRecords::route('/create'),
            'edit' => Pages\EditUploadRecords::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
