<?php

declare(strict_types=1);

namespace App\Modules\Licensing\Middleware;

use App\Modules\Licensing\Services\LicenseVerificationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class VerifyLicense
{
    public function __construct(
        private LicenseVerificationService $licenseService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $licensePath = base_path('license.key');

        if (!$this->licenseService->verify($licensePath)) {
            return response()->view('vendor.licensing.invalid-license', [], 403);
        }

        return $next($request);
    }
}
