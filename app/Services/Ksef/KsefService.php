<?php

declare(strict_types=1);

namespace App\Services\Ksef;

use App\Domain\Payments\Models\Invoice;
use App\Services\Ksef\Contracts\KsefServiceContract;
use Illuminate\Contracts\Config\Repository;
use N1ebieski\KSEFClient\ClientBuilder;
use N1ebieski\KSEFClient\DTOs\Requests\Sessions\Faktura;
use N1ebieski\KSEFClient\Resources\ClientResource;
use N1ebieski\KSEFClient\ValueObjects\Mode;

final class KsefService implements KsefServiceContract
{
    private ?ClientResource $clientResource = null;

    public function __construct(private readonly Repository $repository) {}

    public function getClient(): ClientResource
    {
        if (! $this->clientResource instanceof ClientResource) {
            $builder = (new ClientBuilder)
                ->withMode(Mode::from(strval($this->repository->get('services.ksef.mode'))))
                ->withIdentifier(strval($this->repository->get('services.ksef.nip')));

            if ($token = $this->repository->get('services.ksef.token')) {
                $builder->withKsefToken(strval($token));
            }

            if ($certPath = $this->repository->get('services.ksef.cert_path')) {
                $builder->withCertificatePath(strval($certPath), strval($this->repository->get('services.ksef.cert_passphrase')));
            }

            $this->clientResource = $builder->build();
        }

        return $this->clientResource;
    }

    public function sendInvoice(Invoice $invoice): array
    {
        $clientResource = $this->getClient();

        // 1. Open Session
        $openResponse = $clientResource->sessions()->online()->open([
            'formCode' => 'FA (3)',
        ])->object();

        $referenceNumber = $openResponse->referenceNumber;

        // 2. Map Invoice to DTO (Simplified example)
        $faktura = Faktura::from([
            'Naglowek' => [
                'KodFormularza' => [
                    'value' => 'FA',
                    'kodSystemowy' => 'FA (3)',
                    'wersjaSchemy' => '1-0E',
                ],
                'WariantFormularza' => 3,
                'DataWytworzeniaFa' => now()->toIso8601String(),
            ],
            'Podmiot1' => [
                'DaneIdentyfikacyjne' => [
                    'NIP' => $this->repository->get('services.ksef.nip'),
                ],
            ],
            'Fa' => [
                'P_1' => $invoice->created_at->format('Y-m-d'),
                'P_2' => $invoice->number,
                'P_13_1' => $invoice->amount_net,
                'P_14_1' => $invoice->amount_vat,
                'P_15' => $invoice->amount_gross,
                'KodWaluty' => $invoice->currency,
            ],
        ]);

        // 3. Send Invoice
        $sendResponse = $clientResource->sessions()->online()->send([
            'faktura' => $faktura,
            'referenceNumber' => $referenceNumber,
        ]);

        // 4. Close Session
        $clientResource->sessions()->online()->close([
            'referenceNumber' => $referenceNumber,
        ]);

        return $sendResponse->json();
    }
}
