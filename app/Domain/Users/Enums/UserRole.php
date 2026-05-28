<?php

declare(strict_types=1);

namespace App\Domain\Users\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Moderator = 'moderator';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::Moderator => 'Moderator',
            self::User => 'User',
        };
    }
}
