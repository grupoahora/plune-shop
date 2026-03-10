<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ChevronDown, LogOut } from 'lucide-vue-next';
import UserInfo from '@/components/UserInfo.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { dashboard, logout } from '@/routes';
import type { User } from '@/types';

type Props = {
    user: User;
    buttonClass: string;
};

defineProps<Props>();

const handleLogout = (): void => {
    router.flushAll();
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <button :class="buttonClass" type="button">
                Mi Cuenta
                <ChevronDown class="ml-2 inline-flex size-4" />
            </button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-60">
            <DropdownMenuLabel class="p-0 font-normal">
                <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                    <UserInfo :user="user" :show-email="true" />
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <DropdownMenuItem :as-child="true">
                    <Link class="block w-full cursor-pointer" :href="dashboard()">
                        Mi cuenta
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
            <DropdownMenuItem :as-child="true">
                <Link
                    class="block w-full cursor-pointer"
                    :href="logout()"
                    as="button"
                    @click="handleLogout"
                >
                    <LogOut class="mr-2 h-4 w-4" />
                    Cerrar sesión
                </Link>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
