<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const Admin = 'admin';
    const Moderator = 'moderator';

    public static function Admin(): self
    {
        return new self(self::Admin);
    }

    public static function Moderator(): self
    {
        return new self(self::Moderator);
    }

    public static function getName(self $role): string
    {
        return match ($role->value) {
            self::Admin => 'admin',
            self::Moderator => 'moderator',
        };
    }
}
