<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class SettingTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Key'))),
                TextColumn::make('group')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Group'))),
                TextColumn::make('type')
                    ->badge()
                    ->label(strval(__('Type'))),
                IconColumn::make('is_public')
                    ->boolean()
                    ->label(strval(__('Public'))),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
