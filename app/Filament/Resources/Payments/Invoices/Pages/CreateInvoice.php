<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices\Pages;

use App\Filament\Resources\Payments\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateInvoice extends CreateRecord
{
    #[Override]
    protected static string $resource = InvoiceResource::class;
}
