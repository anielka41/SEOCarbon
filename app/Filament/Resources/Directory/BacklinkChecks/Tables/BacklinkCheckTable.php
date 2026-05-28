<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\BacklinkChecks\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class BacklinkCheckTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entry.name')
                    ->searchable()
                    ->sortable()
                    ->label('Entry'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('checked_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('error_message')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ]);
    }
}
