<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryFields\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class DirectoryFieldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Name'))),
                TextColumn::make('label')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Label'))),
                TextColumn::make('type')
                    ->badge()
                    ->label(strval(__('Type'))),
                IconColumn::make('is_required')
                    ->boolean()
                    ->label(strval(__('Required'))),
                TextColumn::make('sort_order')
                    ->sortable()
                    ->label(strval(__('Sort Order'))),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(strval(__('Created At'))),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
