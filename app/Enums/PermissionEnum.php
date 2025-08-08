<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case USERS_CREATE = 'users.create';
    case USERS_READ = 'users.read';
    case USERS_UPDATE = 'users.update';
    case USERS_DELETE = 'users.delete';

    case ACTIVITIES_CREATE = 'activities.create';
    case ACTIVITIES_READ = 'activities.read';
    case ACTIVITIES_UPDATE = 'activities.update';
    case ACTIVITIES_DELETE = 'activities.delete';

    case PARTICIPANTS_CREATE = 'PARTICIPANTS.create';
    case PARTICIPANTS_READ = 'PARTICIPANTS.read';
    case PARTICIPANTS_UPDATE = 'PARTICIPANTS.update';
    case PARTICIPANTS_DELETE = 'PARTICIPANTS.delete';

    case ACTIVITY_TYPE_CREATE = 'activityType.create';
    case ACTIVITY_TYPE_READ = 'activityType.read';
    case ACTIVITY_TYPE_UPDATE = 'activityType.update';
    case ACTIVITY_TYPE_DELETE = 'activityType.delete';

    case ADMIN_CREATE = 'admin.create';
    case ADMIN_READ = 'admin.read';
    case ADMIN_UPDATE = 'admin.update';
    case ADMIN_DELETE = 'admin.delete';
    case ADMIN_ACCESS = 'admin.access';

    public static function admin(): array
    {
        return array_map(
            fn(PermissionEnum $enum) => $enum->value,
            self::cases()
        );
    }

    public static function editor(): array
    {
        return [
            self::USERS_CREATE->value,
            self::USERS_READ->value,
            self::USERS_UPDATE->value,
            self::ACTIVITIES_CREATE->value,
            self::ACTIVITIES_READ->value,
            self::ACTIVITIES_UPDATE->value,
            self::PARTICIPANTS_CREATE->value,
            self::PARTICIPANTS_READ->value,
            self::PARTICIPANTS_UPDATE->value,
            self::ADMIN_ACCESS->value,
            self::ACTIVITIES_CREATE->value,
            self::ACTIVITIES_READ->value,
            self::ACTIVITIES_UPDATE->value,
        ];
    }

    public static function viewer(): array
    {
        return [
            self::USERS_READ->value,
            self::ACTIVITIES_READ->value,
            self::PARTICIPANTS_READ->value,
            self::ADMIN_ACCESS->value,
            self::ACTIVITIES_READ->value,
        ];
    }
}
