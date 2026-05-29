<?php

declare(strict_types=1);

namespace App\Filament\Resources\Moderation\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class ReviewSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(strval(__('Review Details')))
                    ->schema([
                        Select::make('reviewable_type')
                            ->options([
                                'App\Domain\Directory\Models\DirectoryEntry' => __('DirectoryEntry'),
                                'App\Domain\Blog\Models\Post' => __('Post'),
                            ])
                            ->required()
                            ->label(strval(__('Target Type'))),
                        TextInput::make('reviewable_id')
                            ->numeric()
                            ->required()
                            ->label(strval(__('Target ID'))),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label(strval(__('User'))),
                        TextInput::make('author_name')
                            ->maxLength(255)
                            ->label(strval(__('Author Name'))),
                        TextInput::make('author_email')
                            ->email()
                            ->maxLength(255)
                            ->label(strval(__('Author Email'))),
                        TextInput::make('rating')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->required()
                            ->label(strval(__('Rating'))),
                        Select::make('status')
                            ->options([
                                'pending' => strval(__('Pending')),
                                'approved' => strval(__('Approved')),
                                'rejected' => strval(__('Rejected')),
                                'spam' => strval(__('Spam')),
                            ])
                            ->required()
                            ->label(strval(__('Status'))),
                        Textarea::make('content')
                            ->columnSpanFull()
                            ->label(strval(__('Content'))),
                    ])->columns(2),
            ]);
    }
}
