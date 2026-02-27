<script setup lang="ts">
import { CirclePlus, Heart } from 'lucide-vue-next';
import type { Product } from '@/types';

defineProps<{
    product: Product;
}>();
</script>

<template>
    <div
        class="group flex flex-col gap-5 rounded-2xl bg-card p-2 shadow-md shadow-primary/10 transition-all hover:-translate-y-2 hover:shadow-xl hover:shadow-primary/20 dark:bg-card dark:shadow-black/30">
        <div class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-background">
            <img alt="Producto Plune"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6RDUPCNEGgC5kleedp9hsrURYKBD-hKDvM9BUOKTLKT2SLu13UvLo4nWo3qRfJvkCa5SlsWhD-KPh33aZwGQwjCO2V0-9rmtyoa_sB7Aj7QSRS3jmhdemsumJLyTkuWw5rcGZfztDZIoJrPtPfsesQlVBsYc5QNaB-gBI8F3JLa0QczC1wDkg07JY0hRAJ2O44ntzfGuMVFIRZ_iAD9omUZX5XOQq2saS8HJXPGM44XVTNt208U85KQyyJGfwi-Y6ECVNV1AYVz_T" />
            <button
                class="absolute top-4 right-4 rounded-full border border-white/60 bg-white/70 p-2 text-foreground transition hover:scale-110"
                type="button">
                <Heart class="size-4" />
            </button>
        </div>

        <div class="px-4 pb-4 flex-1 flex flex-col justify-between">
            <div class="mb-2 flex items-start justify-between gap-3">
                <h3 class="text-xl font-bold transition-colors group-hover:text-primary">
                    {{ product.name }}
                </h3>
                <p class="text-lg flex items-start font-extrabold text-foreground dark:text-white">
                    ${{ product.price_sale }}
                </p>
            </div>
            <p class="mb-6 line-clamp-2 text-sm text-muted-foreground dark:text-muted-foreground">
                {{ product.description }}
            </p>
            <button
                class="mt-auto flex w-full items-center justify-center gap-2 rounded-xl bg-background hover:bg-secondary py-3 font-bold text-foreground transition-all hover:bg-primary dark:bg-secondary dark:text-white dark:hover:bg-primary"
                type="button">
                <CirclePlus class="size-4" />
                Agregar al carrito
            </button>
        </div>
    </div>
</template>
