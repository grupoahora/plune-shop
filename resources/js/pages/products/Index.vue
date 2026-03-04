<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import {
    type ColumnFiltersState,
    FlexRender,
    type SortingState,
    createColumnHelper,
    getCoreRowModel,
    getFilteredRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table';
import { ChevronsUpDown } from 'lucide-vue-next';
import { computed, defineAsyncComponent, h, ref, watch } from 'vue';
import { toast } from 'vue-sonner';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useIncrementalPagination } from '@/composables/useIncrementalPagination';
import AppLayout from '@/layouts/AppLayout.vue';
import { type AppPageProps, type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';

const CreateProductSheet = defineAsyncComponent(
    () => import('@/components/products/CreateProductSheet.vue'),
);
const EditProductSheet = defineAsyncComponent(
    () => import('@/components/products/EditProductSheet.vue'),
);
const DeleteProductDialog = defineAsyncComponent(
    () => import('@/components/products/DeleteProductDialog.vue'),
);

interface Product {
    id: number;
    name: string;
    description: string;
    product_code: string;
    image: string | null;
    price_sale: number;
    status: boolean;
    category_id: number;
    category_name: string;
}

interface CategoryOption {
    id: number;
    name: string;
}

const props = defineProps<{
    products: Product[];
    categories: CategoryOption[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const createSheetOpen = ref(false);
const editSheetOpen = ref(false);
const deleteDialogOpen = ref(false);
const selectedProduct = ref<Product | null>(null);
const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);

const createForm = useForm({
    name: '',
    description: '',
    product_code: '',
    image: '',
    price_sale: 0,
    status: true,
    category_id: props.categories[0]?.id ?? null,
    discount_value: null as number | null,
    discount_type: null as string | null,
});

const editForm = useForm({
    name: '',
    description: '',
    product_code: '',
    image: '',
    price_sale: 0,
    status: true,
    category_id: null as number | null,
    discount_value: null as number | null,
    discount_type: null as string | null,
});

const deleteForm = useForm({});
const page = usePage<AppPageProps>();

const showToast = () => {
    const toastPayload = page.props.toast;

    if (!toastPayload) {
        return;
    }

    toast[toastPayload.type](toastPayload.title, {
        description: toastPayload.description,
    });
};

watch(
    () => page.props.toast,
    () => {
        showToast();
    },
    { immediate: true },
);

const submitCreate = () => {
    createForm.post('/dashboard/productos', {
        preserveScroll: true,
        onSuccess: () => {
            createSheetOpen.value = false;
            createForm.reset();
            createForm.status = true;
            createForm.category_id = props.categories[0]?.id ?? null;
            createForm.image = '';
        },
    });
};

const openEdit = (product: Product) => {
    selectedProduct.value = product;
    editForm.name = product.name;
    editForm.description = product.description;
    editForm.product_code = product.product_code;
    editForm.image = product.image ?? '';
    editForm.price_sale = product.price_sale;
    editForm.status = product.status;
    editForm.category_id = product.category_id;
    editSheetOpen.value = true;
};

const submitEdit = () => {
    if (!selectedProduct.value) {
        return;
    }

    editForm.put(`/dashboard/productos/${selectedProduct.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            editSheetOpen.value = false;
            selectedProduct.value = null;
        },
    });
};

const openDelete = (product: Product) => {
    selectedProduct.value = product;
    deleteDialogOpen.value = true;
};

const submitDelete = () => {
    if (!selectedProduct.value) {
        return;
    }

    deleteForm.delete(`/dashboard/productos/${selectedProduct.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            deleteDialogOpen.value = false;
            selectedProduct.value = null;
        },
    });
};

const columnHelper = createColumnHelper<Product>();
const sortableHeader = (label: string, columnId: keyof Product) => {
    return h(
        Button,
        {
            class: 'px-0',
            variant: 'ghost',
            onClick: () => table.getColumn(columnId)?.toggleSorting(),
        },
        () => [
            label,
            h(ChevronsUpDown, {
                class: 'ml-2 h-4 w-4',
            }),
        ],
    );
};

const columns = [
    columnHelper.accessor('name', {
        header: () => sortableHeader('Nombre', 'name'),
        cell: (info) => info.getValue(),
    }),
    columnHelper.accessor('product_code', {
        header: () => sortableHeader('Código', 'product_code'),
        cell: (info) => info.getValue(),
    }),
    columnHelper.accessor('image', {
        header: () => sortableHeader('Imagen', 'image'),
        cell: (info) => (info.getValue() ? 'Configurada' : 'Sin imagen'),
    }),
    columnHelper.accessor('category_name', {
        header: () => sortableHeader('Categoría', 'category_name'),
        cell: (info) => info.getValue(),
    }),
    columnHelper.accessor('price_sale', {
        header: () => sortableHeader('Precio', 'price_sale'),
        cell: (info) => `$${Number(info.getValue()).toFixed(2)}`,
    }),
    columnHelper.accessor('status', {
        header: () => sortableHeader('Estado', 'status'),
        cell: (info) => (info.getValue() ? 'Activo' : 'Inactivo'),
    }),
    columnHelper.display({
        id: 'actions',
        header: () => h('div', { class: 'text-right' }, 'Acciones'),
        cell: ({ row }) =>
            h('div', { class: 'flex justify-end gap-2' }, [
                h(
                    Button,
                    {
                        size: 'sm',
                        variant: 'outline',
                        onClick: () => openEdit(row.original),
                    },
                    () => 'Editar',
                ),
                h(
                    Button,
                    {
                        size: 'sm',
                        variant: 'destructive',
                        onClick: () => openDelete(row.original),
                    },
                    () => 'Eliminar',
                ),
            ]),
    }),
];

const table = useVueTable({
    get data() {
        return props.products;
    },
    columns,
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
    },
    onSortingChange: (updaterOrValue) => {
        sorting.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(sorting.value)
                : updaterOrValue;
    },
    onColumnFiltersChange: (updaterOrValue) => {
        columnFilters.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(columnFilters.value)
                : updaterOrValue;
    },
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getSortedRowModel: getSortedRowModel(),
});

const {
    allItems: filteredRows,
    visibleItems: visibleRows,
    canLoadMore,
    loadMore,
} = useIncrementalPagination(() => table.getRowModel().rows, {
    initialCount: 10,
    incrementCount: 5,
});

const visibleProducts = computed(() => visibleRows.value.length);
const productsTotal = computed(() => filteredRows.value.length);
const hasProducts = computed(() => table.getRowModel().rows.length > 0);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
            <div
                class="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            >
                <div
                    class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
                >
                    <div>
                        <h2 class="text-xl font-bold">Productos</h2>
                        <p class="text-sm text-muted-foreground">
                            Gestiona los productos del catálogo.
                        </p>
                    </div>

                    <Button @click="createSheetOpen = true">Crear producto</Button>
                </div>

                <div class="mb-4 max-w-sm">
                    <Input
                        :model-value="
                            (table.getColumn('name')?.getFilterValue() as string) ??
                            ''
                        "
                        placeholder="Buscar por nombre..."
                        @update:model-value="table.getColumn('name')?.setFilterValue($event)"
                    />
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                v-for="headerGroup in table.getHeaderGroups()"
                                :key="headerGroup.id"
                                class="border-b text-left"
                            >
                                <th
                                    v-for="header in headerGroup.headers"
                                    :key="header.id"
                                    class="py-3"
                                >
                                    <FlexRender
                                        v-if="!header.isPlaceholder"
                                        :render="header.column.columnDef.header"
                                        :props="header.getContext()"
                                    />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="row in visibleRows"
                                :key="row.id"
                                class="border-b border-sidebar-border/60"
                            >
                                <td
                                    v-for="cell in row.getVisibleCells()"
                                    :key="cell.id"
                                    class="py-3"
                                    :class="cell.column.id === 'name' ? 'font-medium' : ''"
                                >
                                    <FlexRender
                                        :render="cell.column.columnDef.cell"
                                        :props="cell.getContext()"
                                    />
                                </td>
                            </tr>

                            <tr v-if="!hasProducts">
                                <td
                                    :colspan="columns.length"
                                    class="py-6 text-center text-muted-foreground"
                                >
                                    No hay productos disponibles.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center justify-between gap-4">
                    <p class="text-sm text-muted-foreground">
                        Mostrando {{ visibleProducts }} de {{ productsTotal }} productos.
                    </p>

                    <Button v-if="canLoadMore" variant="outline" @click="loadMore">
                        Ver más
                    </Button>
                </div>
            </div>
        </div>

        <CreateProductSheet
            v-if="createSheetOpen"
            v-model:open="createSheetOpen"
            :categories="props.categories"
            :errors="createForm.errors"
            :form="createForm"
            :processing="createForm.processing"
            @submit="submitCreate"
            @update:category-id="createForm.category_id = $event"
            @update:description="createForm.description = $event"
            @update:image="createForm.image = $event"
            @update:name="createForm.name = $event"
            @update:price-sale="createForm.price_sale = $event"
            @update:product-code="createForm.product_code = $event"
            @update:status="createForm.status = $event"
        />

        <EditProductSheet
            v-if="editSheetOpen"
            v-model:open="editSheetOpen"
            :categories="props.categories"
            :errors="editForm.errors"
            :form="editForm"
            :processing="editForm.processing"
            @submit="submitEdit"
            @update:category-id="editForm.category_id = $event"
            @update:description="editForm.description = $event"
            @update:image="editForm.image = $event"
            @update:name="editForm.name = $event"
            @update:price-sale="editForm.price_sale = $event"
            @update:product-code="editForm.product_code = $event"
            @update:status="editForm.status = $event"
        />

        <DeleteProductDialog
            v-if="deleteDialogOpen"
            v-model:open="deleteDialogOpen"
            :processing="deleteForm.processing"
            :product-name="selectedProduct?.name ?? null"
            @confirm="submitDelete"
        />
    </AppLayout>
</template>
