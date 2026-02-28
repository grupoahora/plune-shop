<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import CatalogMainContent from '@/components/catalog/CatalogMainContent.vue';
import { useAppearance } from '@/composables/useAppearance';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import { home } from '@/routes';
import { type Product, type BreadcrumbItem } from '@/types';
import type { CatalogCategory, CatalogProduct } from '@/types/catalog';

const CatalogSidebar = defineAsyncComponent(
    () => import('@/components/catalog/CatalogSidebar.vue'),
);

const props = withDefaults(
    defineProps<{
        canResetPassword: boolean;
        products?: CatalogProduct[] | Product[];
        allProducts?: CatalogProduct[] | Product[];
        search?: string;
        categories?: Array<{
            id: number;
            name: string;
            icon: string;
        }>;
    }>(),
    {
        canResetPassword: false,
        products: () => [],
        allProducts: () => [],
        search: '',
        categories: () => [],
    },
);

const categories: CatalogCategory[] = props.categories.map(
    (category, index) => ({
        ...category,
        active: index === 0,
    }),
);

const { resolvedAppearance, updateAppearance } = useAppearance();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inicio',
        href: home().url,
    },
    {
        title: 'Catálogo de Cuidado Capilar',
    },
];

const setAppearance = (value: 'light' | 'dark'): void => {
    updateAppearance(value);
};
const allProducts: Product[] = props.allProducts as Product[];
</script>

<template>
    <Head title="Catálogo de Productos | Plune" />

    <WelcomeLayout
        :products="allProducts"
        :can-reset-password="props.canResetPassword"
        :resolved-appearance="resolvedAppearance"
        @set-appearance="setAppearance"
    >
        <main class="flex-1 px-6 py-8 md:px-20 lg:px-40">
            <div class="mb-8 text-muted-foreground dark:text-primary/60">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>

            <div class="flex flex-col gap-12 lg:flex-row">
                <CatalogSidebar :categories="categories" />
                <CatalogMainContent
                    :products="props.products as CatalogProduct[]"
                    
                    :search="props.search"
                />
            </div>
        </main>
    </WelcomeLayout>
</template>
