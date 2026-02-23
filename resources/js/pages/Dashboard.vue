<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h2 class="text-xl font-bold">Dashboard</h2>
                <p class="text-sm text-muted-foreground">Panel principal.</p>
            </div>
        </div>
    </AppLayout>
</template>
