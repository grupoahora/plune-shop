<?php

namespace App\Support\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class RoleHelper
{
    public const ADMIN = 'admin';

    public const CLIENTE = 'cliente';

    public static function normalize(string $role): string
    {
        return mb_strtolower(trim($role));
    }

    /**
     * @param  array<int, string>|string  $roles
     * @return array<int, string>
     */
    public static function normalizeMany(array|string $roles): array
    {
        $values = is_array($roles) ? $roles : explode(',', $roles);

        return collect($values)
            ->map(fn (string $role): string => self::normalize($role))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<int, string>|string  $roles
     */
    public static function userHasAnyRole(?Authenticatable $user, array|string $roles): bool
    {
        if (! $user instanceof User) {
            return false;
        }

        $allowedRoles = self::normalizeMany($roles);

        if ($allowedRoles === []) {
            return false;
        }

        $currentRoles = $user->roles
            ->pluck('name')
            ->map(fn (string $role): string => self::normalize($role))
            ->all();

        return collect($currentRoles)
            ->intersect($allowedRoles)
            ->isNotEmpty();
    }

    /**
     * @return array{is_admin: bool, is_cliente: bool}
     */
    public static function roleFlags(?Authenticatable $user): array
    {
        return [
            'is_admin' => self::userHasAnyRole($user, self::ADMIN),
            'is_cliente' => self::userHasAnyRole($user, self::CLIENTE),
        ];
    }
}

