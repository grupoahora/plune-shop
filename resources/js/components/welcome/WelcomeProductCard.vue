<script setup lang="ts">
import { CirclePlus, Heart } from 'lucide-vue-next';
import type { Product } from '@/types';

defineProps<{
    product: Product;
}>();
</script>

<template>
    <div
        class="group flex flex-col  gap-5 rounded-2xl border border-[#dbe6df] bg-white p-2 transition-all hover:-translate-y-2 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
        <div class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-[#f6f8f6]">
            <img alt="Producto Plune"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6RDUPCNEGgC5kleedp9hsrURYKBD-hKDvM9BUOKTLKT2SLu13UvLo4nWo3qRfJvkCa5SlsWhD-KPh33aZwGQwjCO2V0-9rmtyoa_sB7Aj7QSRS3jmhdemsumJLyTkuWw5rcGZfztDZIoJrPtPfsesQlVBsYc5QNaB-gBI8F3JLa0QczC1wDkg07JY0hRAJ2O44ntzfGuMVFIRZ_iAD9omUZX5XOQq2saS8HJXPGM44XVTNt208U85KQyyJGfwi-Y6ECVNV1AYVz_T" />
            <button
                class="absolute top-4 right-4 rounded-full border border-white/60 bg-white/70 p-2 text-[#111813] transition hover:scale-110"
                type="button">
                <Heart class="size-4" />
            </button>
        </div>

        <div class="px-4 pb-4 flex-1 flex flex-col justify-between">
            <div class="mb-2 flex items-start justify-between gap-3">
                <h3 class="text-xl font-bold transition-colors group-hover:text-[#13ec5b]">
                    {{ product.name }}
                </h3>
                <p class="text-lg flex items-start font-extrabold text-[#111813] dark:text-white">
                    ${{ product.price_sale }}
                </p>
            </div>
            <p class="mb-6 line-clamp-2 text-sm text-[#61896f] dark:text-[#a1b8a9]">
                {{ product.description }}
            </p>
            <button
                class="flex w-full items-center mt-auto justify-center gap-2 rounded-xl bg-[#f0f4f2] py-3 font-bold text-[#111813] transition-all dark:hover:bg-[#388e55] hover:bg-[#13ec5b] dark:bg-[#2a3a2e] dark:text-white"
                type="button">
                <CirclePlus class="size-4" />
                Agregar al carrito
            </button>
        </div>
    </div>
</template>
