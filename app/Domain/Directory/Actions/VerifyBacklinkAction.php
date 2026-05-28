<?php

declare(strict_types=1);

namespace App\Domain\Directory\Actions;

use App\Domain\Directory\Enums\BacklinkCheckStatus;
use App\Domain\Directory\Models\BacklinkCheck;
use App\Domain\Directory\Models\DirectoryEntry;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final readonly class VerifyBacklinkAction
{
    public function __construct(private Repository $repository) {}

    public function execute(DirectoryEntry $directoryEntry): BacklinkCheck
    {
        $backlinkCheck = BacklinkCheck::query()->create([
            'directory_entry_id' => $directoryEntry->id,
            'status' => BacklinkCheckStatus::Pending,
        ]);

        if (! $directoryEntry->backlink_url) {
            $backlinkCheck->update([
                'status' => BacklinkCheckStatus::Error,
                'error_message' => 'No backlink URL provided.',
                'checked_at' => now(),
            ]);

            return $backlinkCheck;
        }

        try {
            $appUrl = $this->repository->get('app.url');
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'SEOCarbonBot/1.0'])
                ->get($directoryEntry->backlink_url);

            if ($response->failed()) {
                $backlinkCheck->update([
                    'status' => BacklinkCheckStatus::Error,
                    'error_message' => 'HTTP request failed with status: '.$response->status(),
                    'checked_at' => now(),
                ]);

                return $backlinkCheck;
            }

            $html = $response->body();
            $containsBacklink = str_contains($html, (string) $appUrl);

            if ($containsBacklink) {
                $backlinkCheck->update([
                    'status' => BacklinkCheckStatus::Success,
                    'checked_at' => now(),
                ]);

                $directoryEntry->update([
                    'backlink_verified_at' => now(),
                ]);
            } else {
                $backlinkCheck->update([
                    'status' => BacklinkCheckStatus::Failed,
                    'error_message' => 'Backlink not found on the page.',
                    'checked_at' => now(),
                ]);

                $directoryEntry->update([
                    'backlink_verified_at' => null,
                ]);
            }
        } catch (Throwable $throwable) {
            $backlinkCheck->update([
                'status' => BacklinkCheckStatus::Error,
                'error_message' => $throwable->getMessage(),
                'checked_at' => now(),
            ]);

            Log::error(sprintf('Backlink verification error for entry #%s: %s', $directoryEntry->id, $throwable->getMessage()), [
                'entry_id' => $directoryEntry->id,
                'url' => $directoryEntry->backlink_url,
            ]);
        }

        return $backlinkCheck;
    }
}
