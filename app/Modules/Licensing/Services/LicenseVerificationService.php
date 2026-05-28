<?php

declare(strict_types=1);

namespace App\Modules\Licensing\Services;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Request;

final readonly class LicenseVerificationService
{
    private string $publicKey;

    public function __construct(private Repository $repository)
    {
        // Hardcoded public key for SEOCarbon Dirs
        $this->publicKey = <<<'EOD'
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAvI+fqhhQjKsR0xKtmXJa
+8r5uDPItbYJ291dtnaa3icXHAkCHjPxGSIO23oYHgQzz0jxg+EDxDM9LnSTpTW0
/YwaYNMq467qMZr+oE9W+wRu36q3tJEsfgQpuvWqS1/5D9JpVlKJIz/ycd1eGhRn
uOLSULKFsjOhb8s9kWod5/m93DAtSghHAfXkAMaGLY3yoiU6bXIuPENTF/JvrASd
8xlQMHUj1naftRSXkIBOOPCe9aj0qyEQ1JKIVpS0EQACXU137/u1c5yF9NkT3eeX
0unKj/Ux9lG678bfhchG97iY49k4OsLMTirwZutsltSNpKDg5uvMlGAgDWp3UQnz
8mS3r+JZ0Rpp0SEsCeAn4jj8N9lo1jdD5KdVWI/7YmQv9LoasJ/XSopIdZHhqdkL
kQ7hVqmTU+fW+7et7iE0xpR7QhFn3ym6TuyZ7Rgx7kvfxPYhIuaAvXiawJ3iuJxl
GAKRZB34nI4famNcwGKG0TtSd4wphPKVOMGvZrqdrE6vCGmaQlPdkUJJpiNBiLoJ
T7PwvYOg9tpkq6u49H17ENdMuU3ALMjKPC7h7PIo2Senw8LB5Tu0XPam7HVmcqww
dPOHcRH5xriISG9lj0dk47OxlfkMgrQ1mQzBtVrJFozha4BDVt89fEYkKPdWUibx
1POYm8v2YRKLOC9N5MIEGcUCAwEAAQ==
-----END PUBLIC KEY-----
EOD;
    }

    /**
     * Verify the license key file using RSA signature.
     */
    public function verify(string $keyPath): bool
    {
        if ($this->shouldBypassVerification()) {
            return true;
        }

        if (! file_exists($keyPath)) {
            return false;
        }

        $content = file_get_contents($keyPath);
        if ($content === false) {
            return false;
        }

        // Structure: base64(payload).base64(signature)
        $parts = explode('.', $content);
        if (count($parts) !== 2) {
            return false;
        }

        [$payloadB64, $signatureB64] = $parts;
        $payload = base64_decode($payloadB64);
        $signature = base64_decode($signatureB64);

        // Verification logic using OpenSSL
        $ok = openssl_verify($payload, $signature, $this->publicKey, OPENSSL_ALGO_SHA256);

        if ($ok === 1) {
            /** @var array{domain?: string, expires_at?: string} $data */
            $data = json_decode($payload, true);

            // Verify domain
            $currentHost = Request::server('HTTP_HOST') ?? 'localhost';
            // Simple check for localhost or match
            if (isset($data['domain']) && ($data['domain'] === $currentHost || $data['domain'] === 'localhost' || $currentHost === '127.0.0.1')) {

                // Verify expiration
                if (isset($data['expires_at'])) {
                    return strtotime($data['expires_at']) > time();
                }

                return true;
            }
        }

        return false;
    }

    private function shouldBypassVerification(): bool
    {
        if (app()->environment(['local', 'testing'])) {
            return true;
        }

        $host = (string) (Request::server('HTTP_HOST') ?? parse_url((string) $this->repository->get('app.url'), PHP_URL_HOST) ?? 'localhost');

        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
            return true;
        }

        if (str_ends_with($host, '.test')) {
            return true;
        }

        return filter_var($host, FILTER_VALIDATE_IP) && ! filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}
