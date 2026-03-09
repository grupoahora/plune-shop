<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Support\Auth\RoleHelper;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return RoleHelper::userHasAnyRole($user->loadMissing('roles'), [RoleHelper::ADMIN, RoleHelper::CLIENTE]);
    }

    public function view(User $user, Order $order): bool
    {
        if (RoleHelper::userHasAnyRole($user->loadMissing('roles'), RoleHelper::ADMIN)) {
            return true;
        }

        return RoleHelper::userHasAnyRole($user, RoleHelper::CLIENTE)
            && $order->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return RoleHelper::userHasAnyRole($user->loadMissing('roles'), [RoleHelper::ADMIN, RoleHelper::CLIENTE]);
    }

    public function update(User $user, Order $order): bool
    {
        if (RoleHelper::userHasAnyRole($user->loadMissing('roles'), RoleHelper::ADMIN)) {
            return true;
        }

        return RoleHelper::userHasAnyRole($user, RoleHelper::CLIENTE)
            && $order->user_id === $user->id;
    }

    public function delete(User $user, Order $order): bool
    {
        if (RoleHelper::userHasAnyRole($user->loadMissing('roles'), RoleHelper::ADMIN)) {
            return true;
        }

        return RoleHelper::userHasAnyRole($user, RoleHelper::CLIENTE)
            && $order->user_id === $user->id;
    }
}
