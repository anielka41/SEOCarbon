<?php

declare(strict_types=1);

namespace App\Modules\Licensing\Services;

final readonly class LicenseVerificationService
{
    private string $publicKey;

    public function __construct()
    {
        // Hardcoded public key for SEOCarbon Dirs
        $this->publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAkZEFYSp68P936gozqElV
PudDiLSQhJ6nuNhTnRpUkdTUmi790+ZCqKhrOTrNy7qP7wL76e6H96G6dZrvAkC+
b+37oUDyHRz1dglJnUfPDF3BjEgDJy3fXGvXtvq6HTOgxUuzx1KjrH+LYrXrIvqh
iBAkd8ql/gSSWIuFd6RocR8R4RIUWzk1t8HNiALULVFSEoWqZqATU8sWlUtZl7Lm
B9Gvb66Ziuhg3UzbG8YSK/atEKo9fhZ2e7PMUmOljL5gAbDKxC5gMZjAKh4p6BMK
K5wFT0/GmOxOx0acAiX2670hJTluTuZBkvDpooJT73MDDyFd3/lLpJL/EKDLBI24
U0oMZPjDNpRhm6YiNz+mAMSVpkd9BwfK33/CqfLsZ32T5VpTiTBBxcqAR9Cp43KX
dt2e/r11f2+MdgTYWo+bSuaJJfuIiAzDZCsQN2dRfpCsBJcHgv+hFfGhd2Aqj6/d
nyzEIVg/iHFMGgZz8UbfiLQ+KsBqvDlF/Tb6FnoqnL1sTFQvNuwzjZr5m+7eWZL8
Z2CqxB6Df/6P5fzMgr+hrIYxx6vh/rnr7rAHOm0AYQex/CT2hBYPVpZvF8gKEVxJ
PNWPi4apecDipTrbMmSlDCuD6ounoLxROzcEk+/VLW+lA4DjEtvyUIo92NpEuj0T
SvLX5Y3BkxyKidfjydA1CokCAwEAAQ==
-----END PUBLIC KEY-----
EOD;
    }

    /**
     * Verify the license key file using RSA signature.
     */
    public function verify(string $keyPath): bool
    {
        if (!file_exists($keyPath)) {
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
            $currentHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
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
}
