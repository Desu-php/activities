<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case VIEWER = 'viewer';

    public function getPermissions(): array
    {
        return match ($this) {
            self::ADMIN => PermissionEnum::admin(),
            self::EDITOR => PermissionEnum::editor(),
            self::VIEWER => PermissionEnum::viewer(),
        };
    }
}
