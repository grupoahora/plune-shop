<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Sparkles } from 'lucide-vue-next';
import { defineAsyncComponent } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarInset,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarProvider,
    SidebarTrigger,
} from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';
import type { CatalogCategory } from '@/types/catalog';
import { catalogo } from '@/routes';

const LazyCatalogIcon = defineAsyncComponent(
    () => import('@/components/catalog/LazyCatalogIcon.vue'),
);
const CatalogSidebarPromoCard = defineAsyncComponent(
    () => import('@/components/catalog/CatalogSidebarPromoCard.vue'),
);

const props = withDefaults(
    defineProps<{
        categories: CatalogCategory[];
        search?: string;
        selectedCategoryId?: number | null;
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        search: '',
        selectedCategoryId: null,
        breadcrumbs: () => [],
    },
);

const buildCatalogUrl = (categoryId: number | null): string => {
    const query = new URLSearchParams();

    if (props.search.trim() !== '') {
        query.set('search', props.search.trim());
    }

    if (categoryId !== null) {
        query.set('category', String(categoryId));
    }

    const queryString = query.toString();

    if (queryString === '') {
        return catalogo().url;
    }

    return `${catalogo().url}?${queryString}`;
};
</script>

<template>
    <SidebarProvider>
        <Sidebar variant="inset" collapsible="icon">
            <SidebarHeader class="border-b border-sidebar-border/70 px-2 py-4">
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" as-child>
                            <Link :href="catalogo().url">
                                <Sparkles class="size-5 text-primary" />
                                <span>Catálogo</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent class="gap-8 px-2 py-4">
                <SidebarGroup>
                    <SidebarGroupLabel
                        class="mb-2 flex items-center gap-2 text-sm font-bold text-foreground"
                    >
                        Categorías
                    </SidebarGroupLabel>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            <SidebarMenuItem>
                                <SidebarMenuButton
                                    as-child
                                    :is-active="selectedCategoryId === null"
                                >
                                    <Link :href="buildCatalogUrl(null)">
                                        <Sparkles class="size-4" />
                                        <span>Todas</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>

                            <SidebarMenuItem
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <SidebarMenuButton
                                    as-child
                                    :is-active="category.active"
                                >
                                    <Link :href="buildCatalogUrl(category.id)">
                                        <LazyCatalogIcon
                                            :icon-name="category.icon"
                                        />
                                        <span>{{ category.name }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>

                <CatalogSidebarPromoCard />
            </SidebarContent>
        </Sidebar>

        <SidebarInset
            class="bg-transparent shadow-none md:peer-data-[variant=inset]:m-0 md:peer-data-[variant=inset]:rounded-none"
        >
            <header
                class="mb-8 flex items-center gap-2 text-muted-foreground dark:text-primary/60"
            >
                <SidebarTrigger class="-ml-1" />
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </header>
            <slot />
        </SidebarInset>
    </SidebarProvider>
</template>
