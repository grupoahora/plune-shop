<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CatalogMainContent from '@/components/catalog/CatalogMainContent.vue';
import { useAppearance } from '@/composables/useAppearance';
import LayoutCatalogo from '@/layouts/LayoutCatalogo.vue';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import { type Product, type BreadcrumbItem } from '@/types';
import type { CatalogCategory, CatalogProduct } from '@/types/catalog';
import { home } from '@/routes';

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
        selectedCategoryId?: number | null;
    }>(),
    {
        canResetPassword: false,
        products: () => [],
        allProducts: () => [],
        search: '',
        categories: () => [],
        selectedCategoryId: null,
    },
);

const categories: CatalogCategory[] = props.categories.map((category) => ({
    ...category,
    active: category.id === props.selectedCategoryId,
}));

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
            <LayoutCatalogo
                :categories="categories"
                :search="props.search"
                :selected-category-id="props.selectedCategoryId"
                :breadcrumbs="breadcrumbs"
            >
                <CatalogMainContent
                    :products="props.products as CatalogProduct[]"
                    :search="props.search"
                />
            </LayoutCatalogo>
        </main>
    </WelcomeLayout>
</template>
