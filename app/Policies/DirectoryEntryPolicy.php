<?php

declare(strict_types=1);

namespace App\Policies;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Enums\UserRole;
use App\Domain\Users\Models\User;

final class DirectoryEntryPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasAnyRole([
            UserRole::SuperAdmin->value,
            UserRole::Admin->value,
            UserRole::Moderator->value,
        ])) {
            return true;
        }

        return null;
    }

    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, DirectoryEntry $directoryEntry): bool
    {
        return $directoryEntry->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->exists;
    }

    public function update(User $user, DirectoryEntry $directoryEntry): bool
    {
        return $directoryEntry->user_id === $user->id;
    }

    public function delete(User $user, DirectoryEntry $directoryEntry): bool
    {
        return $directoryEntry->user_id === $user->id;
    }

    public function restore(): bool
    {
        return false;
    }

    public function forceDelete(): bool
    {
        return false;
    }
}
