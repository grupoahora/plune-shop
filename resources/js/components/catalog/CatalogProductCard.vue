<script setup lang="ts">
import type { CatalogProduct } from '@/types/catalog';

defineProps<{
    product: CatalogProduct;
}>();
</script>

<template>
    <article
        class="group overflow-hidden rounded-2xl border border-transparent bg-white transition-all duration-300 hover:border-primary/20 hover:shadow-xl dark:bg-white/5"
    >
        <div class="relative aspect-square overflow-hidden">
            <div
                :style="{ backgroundImage: `url('${product.image}')` }"
                class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute top-4 left-4">
                <span
                    class="rounded-full bg-primary px-3 py-1 text-[10px] font-bold tracking-tighter text-[#111813] uppercase"
                    >{{ product.tag }}</span
                >
            </div>
            <button
                class="absolute top-4 right-4 flex size-8 items-center justify-center rounded-full bg-white/80 text-[#111813] opacity-0 backdrop-blur-sm transition-opacity group-hover:opacity-100"
                type="button"
            >
                <span class="material-symbols-outlined text-lg">favorite</span>
            </button>
        </div>

        <div class="p-6">
            <p class="mb-1 text-xs font-semibold text-primary uppercase">
                {{ product.category }}
            </p>
            <h3
                class="mb-2 text-lg font-bold transition-colors group-hover:text-primary"
            >
                {{ product.name }}
            </h3>
            <div class="mb-4 flex items-center gap-1 text-orange-400">
                <span
                    v-for="star in 5"
                    :key="star"
                    :class="[
                        'material-symbols-outlined text-sm',
                        star <= product.rating ? 'filled-icon' : '',
                    ]"
                    >star</span
                >
                <span class="ml-1 text-xs font-bold text-[#61896f] dark:text-primary/40"
                    >({{ product.reviews }})</span
                >
            </div>
            <div class="mt-auto flex items-center justify-between gap-3">
                <p class="text-xl font-extrabold">{{ product.price }}</p>
                <button
                    class="flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold text-[#111813] transition-colors hover:bg-[#0fd952]"
                    type="button"
                >
                    <span class="material-symbols-outlined text-sm"
                        >add_shopping_cart</span
                    >
                    Agregar al carrito
                </button>
            </div>
        </div>
    </article>
</template>
