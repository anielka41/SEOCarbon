<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\RelationManagers;

use App\Filament\Resources\Payments\Invoices\Schemas\InvoiceSchema;
use App\Filament\Resources\Payments\Invoices\Tables\InvoicesTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Override;

final class InvoicesRelationManager extends RelationManager
{
    #[Override]
    protected static string $relationship = 'invoices';

    #[Override]
    public function form(Schema $schema): Schema
    {
        return InvoiceSchema::configure($schema);
    }

    #[Override]
    public function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }
}
