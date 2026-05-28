<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Comments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class CommentSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('Comment Details')))
                ->schema([
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
                ])
                ->columns(2),
        ]);
    }
}
