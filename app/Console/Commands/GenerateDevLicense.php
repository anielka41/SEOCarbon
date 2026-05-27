<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

final class GenerateDevLicense extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:generate {domain=localhost} {--expires=2030-01-01}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a development license key for SEOCarbon Dirs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        /** @var string $domain */
        $domain = $this->argument('domain');
        /** @var string $expires */
        $expires = $this->option('expires');

        $privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIJQQIBADANBgkqhkiG9w0BAQEFAASCCSswggknAgEAAoICAQCRkQVhKnrw/3fq
CjOoSVU+50OItJCEnqe42FOdGlSR1NSaLv3T5kKoqGs5Os3Luo/vAvvp7of3obp1
mu8CQL5v7fuhQPIdHPV2CUmdR88MXcGMSAMnLd9ca9e2+rodM6DFS7PHUqOsf4ti
tesi+qGIECR3yqX+BJJYi4V3pGhxHxHhEhRbOTW3wc2IAtQtUVIShapmoBNTyxaV
S1mXsuYH0a9vrpmK6GDdTNsbxhIr9q0Qqj1+FnZ7s8xSY6WMvmABsMrELmAxmMAq
HinoEwornAVPT8aY7E7HRpwCJfbrvSElOW5O5kGS8OmiglPvcwMPIV3f+Uukkv8Q
oMsEjbhTSgxk+MM2lGGbpiI3P6YAxJWmR30HB8rff8Kp8uxnfZPlWlOJMEHFyoBH
0Knjcpd23Z7+vXV/b4x2BNhaj5tK5okl+4iIDMNkKxA3Z1F+kKwBJcHgv+hFfGhd2
Aqj6/dnyzEIVg/iHFMGgZz8UbfiLQ+KsBqvDlF/Tb6FnoqnL1sTFQvNuwzjZr5m+
7eWZL8Z2CqxB6Df/6P5fzMgr+hrIYxx6vh/rnr7rAHOm0AYQex/CT2hBYPVpZvF8
gKEVxJPNWPi4apecDipTrbMmSlDCuD6ounoLxROzcEk+/VLW+lA4DjEtvyUIo92N
pEuj0TSvLX5Y3BkxyKidfjydA1CokCAwEAAQ==
-----END PRIVATE KEY-----
EOD;

        $payload = json_encode([
            'domain' => $domain,
            'expires_at' => $expires,
            'package' => 'ultimate',
            'created_at' => date('Y-m-d H:i:s'),
        ], JSON_THROW_ON_ERROR);

        $signature = '';
        openssl_sign($payload, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        $content = base64_encode($payload) . '.' . base64_encode($signature);

        file_put_contents(base_path('license.key'), $content);

        $this->info("License key generated for domain: {$domain}");
        $this->info("Expires at: {$expires}");

        return 0;
    }
}
