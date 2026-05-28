<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class InvoiceSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('Invoice Details')))
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(strval(__('User'))),

                    Select::make('listing_id')
                        ->relationship('listing', 'name')
                        ->searchable()
                        ->preload()
                        ->label(strval(__('DirectoryEntry'))),

                    TextInput::make('number')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('Number'))),

                    TextInput::make('currency')
                        ->required()
                        ->default('PLN')
                        ->label(strval(__('Currency'))),

                    Select::make('status')
                        ->options([
                            'draft' => __('Draft'),
                            'issued' => __('Issued'),
                            'confirmed' => __('Confirmed'),
                            'cancelled' => __('Cancelled'),
                        ])
                        ->required()
                        ->label(strval(__('Status'))),
                ])
                ->columns(2),

            Section::make(strval(__('Financials')))
                ->schema([
                    TextInput::make('amount_net')
                        ->numeric()
                        ->required()
                        ->prefix('PLN')
                        ->label(strval(__('Amount Net'))),

                    TextInput::make('amount_vat')
                        ->numeric()
                        ->required()
                        ->prefix('PLN')
                        ->label(strval(__('Amount VAT'))),

                    TextInput::make('amount_gross')
                        ->numeric()
                        ->required()
                        ->prefix('PLN')
                        ->label(strval(__('Amount Gross'))),
                ])
                ->columns(3),
        ]);
    }
}
