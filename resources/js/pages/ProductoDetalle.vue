<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, CirclePlus, ShieldCheck, Truck } from 'lucide-vue-next';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useAppearance } from '@/composables/useAppearance';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import { catalogo, home } from '@/routes';
import type { BreadcrumbItem, Product } from '@/types';
import type { CatalogProduct } from '@/types/catalog';

const props = defineProps<{
    canResetPassword: boolean;
    product: CatalogProduct;
    allproducts?: CatalogProduct[] | Product[];
}>();

const { resolvedAppearance, updateAppearance } = useAppearance();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inicio',
        href: home().url,
    },
    {
        title: 'Catálogo',
        href: catalogo().url,
    },
    {
        title: props.product.name,
    },
];

const setAppearance = (value: 'light' | 'dark'): void => {
    updateAppearance(value);
};
const allproducts: Product[] = props.allproducts as Product[];
</script>

<template>
    <Head :title="`${props.product.name} | Plune`" />

    <WelcomeLayout
        :products="allproducts"
        :can-reset-password="props.canResetPassword"
        :resolved-appearance="resolvedAppearance"
        @set-appearance="setAppearance"
    >
        <main class="flex-1 px-6 py-8 md:px-20 lg:px-40">
            <div class="mb-8 text-muted-foreground dark:text-primary/60">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>

            <section class="grid gap-10 lg:grid-cols-2">
                <article
                    class="overflow-hidden rounded-3xl border border-border bg-card"
                >
                    <img
                        :alt="props.product.name"
                        :src="props.product.image"
                        class="h-full w-full object-cover"
                    />
                </article>

                <article
                    class="space-y-6 rounded-3xl border border-border bg-card p-8"
                >
                    <Badge class="w-fit px-4 py-1">{{
                        props.product.category
                    }}</Badge>

                    <div class="space-y-3">
                        <h1 class="text-4xl leading-tight font-black">
                            {{ props.product.name }}
                        </h1>
                        <p class="text-sm font-semibold text-primary">
                            Código: {{ props.product.productCode }}
                        </p>
                        <p class="text-muted-foreground">
                            {{ props.product.description }}
                        </p>
                    </div>

                    <p class="text-3xl font-extrabold">
                        {{ props.product.price }}
                    </p>

                    <div class="grid gap-3 text-sm">
                        <p
                            class="flex items-center gap-2 text-muted-foreground"
                        >
                            <Truck class="size-4 text-primary" /> Entrega
                            nacional en 24-72 horas.
                        </p>
                        <p
                            class="flex items-center gap-2 text-muted-foreground"
                        >
                            <ShieldCheck class="size-4 text-primary" /> Garantía
                            de satisfacción Plune.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <Button class="gap-2" size="lg" type="button">
                            <CirclePlus class="size-4" />
                            Agregar al carrito
                        </Button>

                        <Link :href="catalogo().url">
                            <Button size="lg" type="button" variant="outline">
                                <ArrowLeft class="size-4" />
                                Volver al catálogo
                            </Button>
                        </Link>
                    </div>
                </article>
            </section>
        </main>
    </WelcomeLayout>
</template>
