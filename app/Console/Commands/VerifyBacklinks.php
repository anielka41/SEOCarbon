<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domain\Directory\Actions\VerifyBacklinkAction;
use App\Domain\Directory\Enums\BacklinkCheckStatus;
use App\Domain\Directory\Models\DirectoryEntry;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;

#[Description('Verify if listings have required backlink to our directory')]
#[Signature('directory:verify-backlinks')]
final class VerifyBacklinks extends Command
{
    public function handle(VerifyBacklinkAction $verifyBacklinkAction): void
    {
        $this->info('Starting backlink verification...');

        $directoryEntries = DirectoryEntry::query()->whereNotNull('backlink_url')
            ->where(function (Builder $builder): void {
                $builder->whereNull('backlink_verified_at')
                    ->orWhere('backlink_verified_at', '<', now()->subDays(7));
            })
            ->get();

        $this->info(sprintf('Found %s listings to verify.', $directoryEntries->count()));

        foreach ($directoryEntries as $directoryEntry) {
            $this->info(sprintf('Verifying: %s...', $directoryEntry->name));
            $check = $verifyBacklinkAction->execute($directoryEntry);

            if ($check->status === BacklinkCheckStatus::Success->value) {
                $this->info('Verified backlink for: '.$directoryEntry->name);
            } else {
                $this->warn(sprintf('Failed verification for: %s - %s', $directoryEntry->name, $check->error_message));
            }
        }

        $this->info('Backlink verification completed.');
    }
}
