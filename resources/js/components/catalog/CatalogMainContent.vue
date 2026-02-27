<script setup lang="ts">
import { ChevronDown, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import CatalogProductCard from '@/components/catalog/CatalogProductCard.vue';
import { Button } from '@/components/ui/button';
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
                <p
                    class="font-medium text-muted-foreground dark:text-primary/40"
                >
                    {{ products.length }} productos naturales de alto
                    rendimiento encontrados
                </p>
            </div>
            <Button
                class="flex items-center gap-2"
                type="button"
                variant="outline"
            >
                Ordenar por: Más Vendidos
                <ChevronDown class="size-4" />
            </Button>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-2">
            <CatalogProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>

        <div class="mt-16 flex items-center justify-center gap-4">
            <Button size="icon" type="button" variant="outline">
                <ChevronLeft class="size-5" />
            </Button>
            <span
                class="rounded-xl bg-primary px-4 py-2 font-bold text-foreground"
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
            <Button size="icon" type="button" variant="outline">
                <ChevronRight class="size-5" />
            </Button>
        </div>
    </section>
</template>
