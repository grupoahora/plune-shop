<script setup lang="ts">
import CatalogProductCard from '@/components/catalog/CatalogProductCard.vue';
import type { CatalogProduct } from '@/types/catalog';

defineProps<{
    products: CatalogProduct[];
}>();
</script>

<template>
    <section class="flex-1">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <h1 class="mb-2 text-3xl font-extrabold tracking-tight">
                    Catálogo de Productos
                </h1>
                <p class="font-medium text-[#61896f] dark:text-primary/40">
                    {{ products.length }} productos naturales de alto
                    rendimiento encontrados
                </p>
            </div>
            <button
                class="flex items-center gap-2 rounded-lg border border-[#f0f4f2] bg-white px-4 py-2 text-sm font-bold shadow-sm dark:border-white/10 dark:bg-background-dark"
                type="button"
            >
                Ordenar por: Más Vendidos
                <span class="material-symbols-outlined text-sm"
                    >keyboard_arrow_down</span
                >
            </button>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-2">
            <CatalogProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>

        <div class="mt-16 flex items-center justify-center gap-4">
            <button
                class="rounded-full border border-primary/10 p-2 transition-colors hover:bg-primary/10"
                type="button"
            >
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <span class="rounded-xl bg-primary px-4 py-2 font-bold text-[#111813]"
                >1</span
            >
            <span
                class="cursor-pointer rounded-xl px-4 py-2 font-bold hover:bg-white dark:hover:bg-white/5"
                >2</span
            >
            <span
                class="cursor-pointer rounded-xl px-4 py-2 font-bold hover:bg-white dark:hover:bg-white/5"
                >3</span
            >
            <button
                class="rounded-full border border-primary/10 p-2 transition-colors hover:bg-primary/10"
                type="button"
            >
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </section>
</template>
