<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { CirclePlus, Heart, Star } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import type { CatalogProduct } from '@/types/catalog';

const props = defineProps<{
    product: CatalogProduct;
}>();
console.log(props.product.category);

</script>

<template>
    <article
        class="group flex flex-col gap-5 rounded-2xl bg-card p-2 shadow-md shadow-primary/10 transition-all hover:-translate-y-2 hover:shadow-xl hover:shadow-primary/20 dark:bg-card dark:shadow-black/30"
    >
        <div
            class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-muted"
        >
            <div
                :style="{ backgroundImage: `url('${product.image}')` }"
                class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-500 group-hover:scale-105"
            />

            <Badge
                class="absolute top-4 left-4 px-3 py-1 text-[10px] font-bold tracking-tighter uppercase"
            >
                {{ props.product.category }}
            </Badge>

            <button
                class="absolute top-4 right-4 rounded-full border border-white/60 bg-white/70 p-2 text-foreground transition hover:scale-110"
                type="button"
            >
                <Heart class="size-4" />
            </button>
        </div>

        <div class="flex flex-1 flex-col justify-between px-4 pb-4">
            <div>
                <p class="mb-1 text-xs font-semibold text-primary uppercase">
                    {{ props.product.category}}
                </p>
                <div class="mb-2 flex items-start justify-between gap-3">
                    <Link
                        :href="`/productos/${props.product.id}`"
                        class="text-xl font-bold transition-colors group-hover:text-primary"
                    >
                        {{ props.product.name }}
                    </Link>
                    <p
                        class="flex items-start text-lg font-extrabold text-foreground dark:text-white"
                    >
                        {{ props.product.price }}
                    </p>
                </div>
            </div>
            <div>
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
                        class="ml-1 text-xs font-bold text-muted-foreground dark:text-muted-foreground"
                    >
                        ({{ product.reviews }})
                    </span>
                </div>

                <button
                    class="mt-auto flex w-full items-center justify-center gap-2 rounded-xl bg-muted py-3 font-bold text-foreground transition-all hover:bg-secondary dark:bg-secondary dark:text-white dark:hover:bg-primary"
                    type="button"
                >
                    <CirclePlus class="size-4" />
                    Agregar al carrito
                </button>
            </div>
        </div>
    </article>
</template>
