<?php

declare(strict_types=1);

namespace App\Services\Payments\Contracts;

interface PaymentGateway
{
    /**
     * @param  array<string, mixed>  $params
     * @return string Redirect URL or session ID
     */
    public function createSession(array $params): string;

    public function handleWebhook(array $payload): bool;
}
