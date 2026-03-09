<?php

namespace App\Policies;

use App\Models\OrderItem;
use App\Models\User;
use App\Support\Auth\RoleHelper;

class OrderItemPolicy
{
    public function viewAny(User $user): bool
    {
        return RoleHelper::userHasAnyRole($user->loadMissing('roles'), [RoleHelper::ADMIN, RoleHelper::CLIENTE]);
    }

    public function view(User $user, OrderItem $orderItem): bool
    {
        if (RoleHelper::userHasAnyRole($user->loadMissing('roles'), RoleHelper::ADMIN)) {
            return true;
        }

        return RoleHelper::userHasAnyRole($user, RoleHelper::CLIENTE)
            && $orderItem->order?->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return RoleHelper::userHasAnyRole($user->loadMissing('roles'), [RoleHelper::ADMIN, RoleHelper::CLIENTE]);
    }

    public function update(User $user, OrderItem $orderItem): bool
    {
        if (RoleHelper::userHasAnyRole($user->loadMissing('roles'), RoleHelper::ADMIN)) {
            return true;
        }

        return RoleHelper::userHasAnyRole($user, RoleHelper::CLIENTE)
            && $orderItem->order?->user_id === $user->id;
    }

    public function delete(User $user, OrderItem $orderItem): bool
    {
        if (RoleHelper::userHasAnyRole($user->loadMissing('roles'), RoleHelper::ADMIN)) {
            return true;
        }

        return RoleHelper::userHasAnyRole($user, RoleHelper::CLIENTE)
            && $orderItem->order?->user_id === $user->id;
    }
}
