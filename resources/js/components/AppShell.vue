<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Toaster } from '@/components/ui/sonner';
import { SidebarProvider } from '@/components/ui/sidebar';
import type { AppShellVariant } from '@/types';

type Props = {
    variant?: AppShellVariant;
};

defineProps<Props>();

const isOpen = usePage().props.sidebarOpen;
</script>

<template>
    <div v-if="variant === 'header'" class="flex min-h-screen w-full flex-col">
        <slot />
        <Toaster close-button position="top-right" rich-colors />
    </div>
    <SidebarProvider v-else :default-open="isOpen">
        <slot />
        <Toaster close-button position="top-right" rich-colors />
    </SidebarProvider>
</template>
