<script setup lang="ts">
import {
    Droplets,
    Flower2,
    Leaf,
    type LucideIcon,
    Sparkles,
    Waves,
} from 'lucide-vue-next';
import type { CatalogCategory } from '@/types/catalog';

defineProps<{
    categories: CatalogCategory[];
}>();

const categoryIcons: Record<string, LucideIcon> = {
    spa: Flower2,
    water_drop: Droplets,
    brush: Waves,
    eco: Leaf,
};

const getCategoryIcon = (iconName: string): LucideIcon => {
    return categoryIcons[iconName] ?? Sparkles;
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
                    <a
                        v-for="category in categories"
                        :key="category.id"
                        :class="[
                            'group flex items-center gap-3 rounded-xl px-4 py-3 transition-all',
                            category.active
                                ? 'bg-primary/10 font-semibold text-[#111813] dark:text-white'
                                : 'text-[#61896f] hover:bg-white hover:text-primary dark:text-primary/40 dark:hover:bg-white/5',
                        ]"
                        href="#"
                    >
                        <component
                            :is="getCategoryIcon(category.icon)"
                            :class="[
                                'size-5',
                                category.active
                                    ? 'text-primary'
                                    : 'text-current',
                            ]"
                        />
                        <span>{{ category.name }}</span>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-primary/10 bg-primary/5 p-6">
                <p
                    class="mb-2 text-xs font-bold tracking-widest text-primary uppercase"
                >
                    Elección Sostenible
                </p>
                <h4 class="mb-2 font-bold">Recarga y Ahorra</h4>
                <p class="mb-4 text-sm text-[#61896f] dark:text-white/60">
                    Suscríbete a recargas y obtén un 15% de descuento en tu
                    rutina orgánica.
                </p>
                <a
                    class="text-sm font-bold underline decoration-primary underline-offset-4"
                    href="#"
                    >Saber más</a
                >
            </div>
        </div>
    </aside>
</template>
