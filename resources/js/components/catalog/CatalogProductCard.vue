<script setup lang="ts">
import { CirclePlus, Heart, Star } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import type { CatalogProduct } from '@/types/catalog';

defineProps<{
    product: CatalogProduct;
}>();
</script>

<template>
    <article
        class="group flex flex-col gap-5 rounded-2xl border border-[#dbe6df] bg-white p-2 transition-all hover:-translate-y-2 dark:border-[#2a3a2e] dark:bg-[#1a2e20]"
    >
        <div
            class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-[#f6f8f6]"
        >
            <div
                :style="{ backgroundImage: `url('${product.image}')` }"
                class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-500 group-hover:scale-105"
            />

            <Badge
                class="absolute top-4 left-4 px-3 py-1 text-[10px] font-bold tracking-tighter uppercase"
            >
                {{ product.tag }}
            </Badge>

            <button
                class="absolute top-4 right-4 rounded-full border border-white/60 bg-white/70 p-2 text-[#111813] transition hover:scale-110"
                type="button"
            >
                <Heart class="size-4" />
            </button>
        </div>

        <div class="flex flex-1 flex-col justify-between px-4 pb-4">
            <p class="mb-1 text-xs font-semibold text-primary uppercase">
                {{ product.category }}
            </p>

            <div class="mb-2 flex items-start justify-between gap-3">
                <h3
                    class="text-xl font-bold transition-colors group-hover:text-[#13ec5b]"
                >
                    {{ product.name }}
                </h3>
                <p
                    class="flex items-start text-lg font-extrabold text-[#111813] dark:text-white"
                >
                    {{ product.price }}
                </p>
            </div>

            <div class="mb-6 flex items-center gap-1 text-orange-400">
                <Star
                    v-for="star in 5"
                    :key="star"
                    :class="[
                        'size-4',
                        star <= product.rating
                            ? 'fill-current text-orange-400'
                            : 'fill-transparent text-orange-300',
                    ]"
                />
                <span
                    class="ml-1 text-xs font-bold text-[#61896f] dark:text-[#a1b8a9]"
                >
                    ({{ product.reviews }})
                </span>
            </div>

            <button
                class="mt-auto flex w-full items-center justify-center gap-2 rounded-xl bg-[#f0f4f2] py-3 font-bold text-[#111813] transition-all hover:bg-[#13ec5b] dark:bg-[#2a3a2e] dark:text-white"
                type="button"
            >
                <CirclePlus class="size-4" />
                Agregar al carrito
            </button>
        </div>
    </article>
</template>
