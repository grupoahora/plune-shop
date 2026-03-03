<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Sparkles } from 'lucide-vue-next';
import { defineAsyncComponent } from 'vue';
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
    <aside class="w-full flex-shrink-0 lg:w-64">
        <div class="sticky top-28 space-y-8">
            <div>
                <h3 class="mb-6 flex items-center gap-2 text-lg font-bold">
                    <Sparkles class="size-5 text-primary" />
                    Categorías
                </h3>
                <div class="flex flex-col gap-2">
                    <Link
                        :class="[
                            'group flex items-center gap-3 rounded-xl px-4 py-3 transition-all',
                            selectedCategoryId === null
                                ? 'bg-primary/10 font-semibold text-foreground dark:text-white'
                                : 'text-muted-foreground hover:bg-white hover:text-primary dark:text-primary/40 dark:hover:bg-white/5',
                        ]"
                        :href="buildCatalogUrl(null)"
                    >
                        <span>Todas</span>
                    </Link>

                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :class="[
                            'group flex items-center gap-3 rounded-xl px-4 py-3 transition-all',
                            category.active
                                ? 'bg-primary/10 font-semibold text-foreground dark:text-white'
                                : 'text-muted-foreground hover:bg-white hover:text-primary dark:text-primary/40 dark:hover:bg-white/5',
                        ]"
                        :href="buildCatalogUrl(category.id)"
                    >
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
                </div>
            </div>

            <CatalogSidebarPromoCard />
        </div>
    </aside>
</template>
