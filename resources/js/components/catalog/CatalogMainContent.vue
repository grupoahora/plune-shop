<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    Search,
} from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';
import CatalogProductCard from '@/components/catalog/CatalogProductCard.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { CatalogProduct } from '@/types/catalog';

const CATALOG_PRODUCTS_CACHE_KEY = 'catalog-products-cache';

const props = defineProps<{
    products: CatalogProduct[];
    allProducts: CatalogProduct[];
    search?: string;
}>();

const searchTerm = ref(props.search ?? '');
const displayedProducts = ref<CatalogProduct[]>(props.products);

const getCachedProducts = (): CatalogProduct[] => {
    const cachedProducts = window.localStorage.getItem(
        CATALOG_PRODUCTS_CACHE_KEY,
    );

    if (cachedProducts === null) {
        return [];
    }

    try {
        const parsedProducts = JSON.parse(cachedProducts) as CatalogProduct[];

        return Array.isArray(parsedProducts) ? parsedProducts : [];
    } catch {
        return [];
    }
};

const updateProductsCache = (products: CatalogProduct[]): void => {
    if (products.length === 0) {
        return;
    }

    window.localStorage.setItem(
        CATALOG_PRODUCTS_CACHE_KEY,
        JSON.stringify(products),
    );
};

const sourceProducts = computed<CatalogProduct[]>(() => {
    if (props.allProducts.length > 0) {
        return props.allProducts;
    }

    const cachedProducts = getCachedProducts();

    if (cachedProducts.length > 0) {
        return cachedProducts;
    }

    return props.products;
});

const filteredProducts = computed<CatalogProduct[]>(() => {
    const normalizedSearchTerm = searchTerm.value.trim().toLowerCase();

    if (normalizedSearchTerm === '') {
        return sourceProducts.value;
    }

    return sourceProducts.value.filter((product) => {
        return (
            product.name.toLowerCase().includes(normalizedSearchTerm) ||
            product.productCode.toLowerCase().includes(normalizedSearchTerm)
        );
    });
});

const searchProduct = (): void => {
    displayedProducts.value = filteredProducts.value;
};

onMounted(() => {
    updateProductsCache(props.allProducts);
    searchProduct();
});

watch(
    () => props.allProducts,
    (allProducts) => {
        updateProductsCache(allProducts);
    },
    { deep: true },
);

watch(
    () => props.products,
    () => {
        searchProduct();
    },
    { deep: true },
);
</script>

<template>
    <section class="flex-1">
        <div
            class="mb-8 flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between"
        >
            <div>
                <h1 class="mb-2 text-3xl font-extrabold tracking-tight">
                    Catálogo de Productos
                </h1>
                <p
                    class="font-medium text-muted-foreground dark:text-primary/40"
                >
                    {{ displayedProducts.length }} productos naturales de alto
                    rendimiento encontrados
                </p>
            </div>

            <form
                class="flex w-full max-w-xl items-center"
                @submit.prevent="searchProduct"
            >
                <div class="flex w-full items-center">
                    <Input
                        v-model="searchTerm"
                        class="rounded-r-none"
                        placeholder="Buscar por nombre o código de producto"
                        type="search"
                    />
                    <Button class="rounded-l-none" type="submit">
                        <Search class="size-4" />
                        Buscar
                    </Button>
                </div>
            </form>

            <Button
                class="flex items-center gap-2"
                type="button"
                variant="outline"
            >
                Ordenar por: Más Vendidos
                <ChevronDown class="size-4" />
            </Button>
        </div>

        <div
            v-if="displayedProducts.length"
            class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-2"
        >
            <CatalogProductCard
                v-for="product in displayedProducts"
                :key="product.id"
                :product="product"
            />
        </div>

        <div
            v-else
            class="rounded-2xl border border-dashed border-border px-6 py-12 text-center"
        >
            <h2 class="text-xl font-bold">Sin resultados</h2>
            <p class="mt-2 text-muted-foreground">
                Ajusta tu búsqueda para encontrar el producto ideal.
            </p>
            <Link
                class="mt-4 inline-flex text-sm font-semibold text-primary"
                href="/catalogo"
            >
                Limpiar búsqueda
            </Link>
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
