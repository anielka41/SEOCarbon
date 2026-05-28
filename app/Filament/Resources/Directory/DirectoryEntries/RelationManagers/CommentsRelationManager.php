<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;

final class CommentsRelationManager extends RelationManager
{
    #[Override]
    protected static string $relationship = 'comments';

    #[Override]
    protected static ?string $recordTitleAttribute = 'id';

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->label(strval(__('Author'))),
            TextInput::make('rating')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->label(strval(__('Rating'))),
            Textarea::make('content')
                ->required()
                ->columnSpanFull()
                ->label(strval(__('Content'))),
            Toggle::make('is_approved')
                ->label(strval(__('Is Approved'))),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(strval(__('Author'))),
                TextColumn::make('rating')
                    ->label(strval(__('Rating'))),
                TextColumn::make('content')
                    ->limit(50)
                    ->label(strval(__('Content'))),
                IconColumn::make('is_approved')
                    ->boolean()
                    ->label(strval(__('Approved'))),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label(strval(__('Created At'))),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
