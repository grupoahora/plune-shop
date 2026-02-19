<script setup lang="ts">
import type { CatalogCategory } from '@/types/catalog';

defineProps<{
    categories: CatalogCategory[];
}>();
</script>

<template>
    <aside class="w-full flex-shrink-0 lg:w-64">
        <div class="sticky top-28 space-y-8">
            <div>
                <h3 class="mb-6 flex items-center gap-2 text-lg font-bold">
                    <span class="material-symbols-outlined text-primary"
                        >filter_list</span
                    >
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
                        <span
                            :class="[
                                'material-symbols-outlined',
                                category.active ? 'filled-icon text-primary' : '',
                            ]"
                            >{{ category.icon }}</span
                        >
                        <span>{{ category.name }}</span>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-primary/10 bg-primary/5 p-6">
                <p class="mb-2 text-xs font-bold uppercase tracking-widest text-primary">
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
