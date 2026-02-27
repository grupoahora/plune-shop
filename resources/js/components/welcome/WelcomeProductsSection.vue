<script setup lang="ts">
import { ChevronsRight } from 'lucide-vue-next';
import WelcomeProductCard from '@/components/welcome/WelcomeProductCard.vue';
import type { Product } from '@/types';

defineProps<{
    products: Product[];
}>();
</script>

<template>
    <section class="px-6 py-16 md:px-20">
        <div class="mb-12 flex items-end justify-between">
            <div class="space-y-2">
                <h2 class="text-4xl font-extrabold tracking-tight">
                    Nuestros Productos
                </h2>
                <p
                    class="text-lg font-medium text-[#6C3483] dark:text-[#D2B4DE]"
                >
                    Cuidadosamente elaborados para cada tipo de cabello.
                </p>
            </div>
            <a
                class="flex items-center gap-2 font-bold text-[#884EA0] hover:underline"
                href="#"
            >
                Ver todos
                <ChevronsRight class="size-8" />
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <WelcomeProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>
    </section>
</template>
