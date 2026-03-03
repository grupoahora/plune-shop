<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Sparkles } from 'lucide-vue-next';
import { defineAsyncComponent } from 'vue';
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import type { CatalogCategory } from '@/types/catalog';

const LazyCatalogIcon = defineAsyncComponent(
    () => import('@/components/catalog/LazyCatalogIcon.vue'),
);
const CatalogSidebarPromoCard = defineAsyncComponent(
    () => import('@/components/catalog/CatalogSidebarPromoCard.vue'),
);

const props = withDefaults(
    defineProps<{
        categories: CatalogCategory[];
        catalogUrl: string;
        search?: string;
        selectedCategoryId?: number | null;
    }>(),
    {
        search: '',
        selectedCategoryId: null,
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
        return props.catalogUrl;
    }

    return `${props.catalogUrl}?${queryString}`;
};
</script>

<template>
    <Sidebar
        collapsible="none"
        class="hidden h-fit border-none bg-transparent lg:flex lg:w-64"
    >
        <SidebarContent class="gap-8">
            <SidebarGroup>
                <SidebarGroupLabel class="mb-4 flex items-center gap-2 px-0 text-base font-bold text-foreground">
                    <Sparkles class="size-5 text-primary" />
                    Categorías
                </SidebarGroupLabel>

                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem>
                            <SidebarMenuButton
                                as-child
                                :class="[
                                    'h-auto rounded-xl px-4 py-3 text-sm',
                                    selectedCategoryId === null
                                        ? 'bg-primary/10 font-semibold text-foreground dark:text-white'
                                        : 'text-muted-foreground hover:bg-white hover:text-primary dark:text-primary/40 dark:hover:bg-white/5',
                                ]"
                            >
                                <Link :href="buildCatalogUrl(null)">
                                    <span>Todas</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>

                        <SidebarMenuItem v-for="category in categories" :key="category.id">
                            <SidebarMenuButton
                                as-child
                                :class="[
                                    'h-auto rounded-xl px-4 py-3 text-sm',
                                    category.active
                                        ? 'bg-primary/10 font-semibold text-foreground dark:text-white'
                                        : 'text-muted-foreground hover:bg-white hover:text-primary dark:text-primary/40 dark:hover:bg-white/5',
                                ]"
                            >
                                <Link :href="buildCatalogUrl(category.id)">
                                    <LazyCatalogIcon
                                        :class="[
                                            category.active
                                                ? 'text-primary'
                                                : 'text-current',
                                        ]"
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
</template>
