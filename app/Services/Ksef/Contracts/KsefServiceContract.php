<?php

declare(strict_types=1);

namespace App\Services\Ksef\Contracts;

use App\Domain\Payments\Models\Invoice;
use N1ebieski\KSEFClient\Resources\ClientResource;

interface KsefServiceContract
{
    public function getClient(): ClientResource;

    public function sendInvoice(Invoice $invoice): array;
}
