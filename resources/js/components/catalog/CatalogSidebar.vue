<script setup lang="ts">
import { Sparkles } from 'lucide-vue-next';
import { defineAsyncComponent } from 'vue';
import type { CatalogCategory } from '@/types/catalog';

const LazyCatalogIcon = defineAsyncComponent(
    () => import('@/components/catalog/LazyCatalogIcon.vue'),
);
const CatalogSidebarPromoCard = defineAsyncComponent(
    () => import('@/components/catalog/CatalogSidebarPromoCard.vue'),
);

defineProps<{
    categories: CatalogCategory[];
}>();
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
                    <a
                        v-for="category in categories"
                        :key="category.id"
                        :class="[
                            'group flex items-center gap-3 rounded-xl px-4 py-3 transition-all',
                            category.active
                                ? 'bg-primary/10 font-semibold text-foreground dark:text-white'
                                : 'text-muted-foreground hover:bg-white hover:text-primary dark:text-primary/40 dark:hover:bg-white/5',
                        ]"
                        href="#"
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
                    </a>
                </div>
            </div>

            <CatalogSidebarPromoCard />
        </div>
    </aside>
</template>
