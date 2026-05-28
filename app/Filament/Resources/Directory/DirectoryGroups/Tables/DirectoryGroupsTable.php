<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryGroups\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class DirectoryGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Name'))),

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable()
                    ->label(strval(__('Price'))),

                TextColumn::make('duration_days')
                    ->suffix(' days')
                    ->label(strval(__('Duration'))),

                IconColumn::make('is_promoted')
                    ->boolean()
                    ->label(strval(__('Promoted'))),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label(strval(__('Active'))),

                TextColumn::make('entries_count')
                    ->counts('entries')
                    ->label(strval(__('DirectoryEntries'))),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
