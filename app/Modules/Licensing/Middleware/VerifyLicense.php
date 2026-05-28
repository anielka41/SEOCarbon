<?php

declare(strict_types=1);

namespace App\Modules\Licensing\Middleware;

use App\Modules\Licensing\Services\LicenseVerificationService;
use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class VerifyLicense
{
    public function __construct(
        private LicenseVerificationService $licenseVerificationService, private ResponseFactory $responseFactory
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $licensePath = base_path('license.key');

        if (! $this->licenseVerificationService->verify($licensePath)) {
            return $this->responseFactory->view('vendor.licensing.invalid-license', [], 403);
        }

        return $next($request);
    }
}
