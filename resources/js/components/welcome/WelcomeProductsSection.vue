<script setup lang="ts">
import { ChevronsRight } from 'lucide-vue-next';
import type { CatalogProduct } from '@/types/catalog';
import CatalogProductCard from '../catalog/CatalogProductCard.vue';

defineProps<{
    products: CatalogProduct[];
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
                    class="text-lg font-medium text-muted-foreground dark:text-muted-foreground"
                >
                    Cuidadosamente elaborados para cada tipo de cabello.
                </p>
            </div>
            <a
                class="flex items-center gap-2 font-bold text-primary hover:underline"
                href="#"
            >
                Ver todos
                <ChevronsRight class="size-8" />
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <CatalogProductCard v-for="product in products" :key="product.id" :product="product" />
        </div>
    </section>
</template>
