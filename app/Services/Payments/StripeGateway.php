<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGateway;

final readonly class StripeGateway implements PaymentGateway
{
    public function createSession(array $params): string
    {
        // Skeleton for Stripe session creation
        // In real implementation: Stripe\Checkout\Session::create(...)
        return 'https://checkout.stripe.com/pay/mock_session';
    }

    public function handleWebhook(array $payload): bool
    {
        // Skeleton for Stripe webhook handling
        return true;
    }
}
