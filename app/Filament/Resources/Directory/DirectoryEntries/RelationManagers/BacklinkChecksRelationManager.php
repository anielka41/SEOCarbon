<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\RelationManagers;

use Filament\Actions\DeleteAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;

final class BacklinkChecksRelationManager extends RelationManager
{
    #[Override]
    protected static string $relationship = 'backlinkChecks';

    #[Override]
    protected static ?string $recordTitleAttribute = 'uuid';

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema; // Read-only for now
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label(strval(__('UUID')))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->label(strval(__('Status'))),
                TextColumn::make('checked_at')
                    ->dateTime()
                    ->label(strval(__('Checked At'))),
                TextColumn::make('error_message')
                    ->limit(50)
                    ->label(strval(__('Error Message'))),
            ])
            ->defaultSort('checked_at', 'desc')
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
