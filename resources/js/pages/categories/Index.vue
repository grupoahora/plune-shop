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

const CreateCategorySheet = defineAsyncComponent(
    () => import('@/components/categories/CreateCategorySheet.vue'),
);
const EditCategorySheet = defineAsyncComponent(
    () => import('@/components/categories/EditCategorySheet.vue'),
);
const DeleteCategoryDialog = defineAsyncComponent(
    () => import('@/components/categories/DeleteCategoryDialog.vue'),
);

interface Category {
    id: number;
    name: string;
    icon: string;
    sort_order: number;
}

const props = defineProps<{
    categories: Category[];
    iconOptions: string[];
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
const selectedCategory = ref<Category | null>(null);
const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);

const createForm = useForm({
    name: '',
    icon: 'Flower2',
    sort_order: 0,
});

const editForm = useForm({
    name: '',
    icon: '',
    sort_order: 0,
});

const deleteForm = useForm({});

const page = usePage<AppPageProps>();

const showToast = () => {
    const toastPayload = page.props.toast;

    if (!toastPayload) {
        return;
    }

    const action = toastPayload.undoToken
        ? {
              label: 'Deshacer',
              onClick: () => {
                  useForm({ undo_token: toastPayload.undoToken }).post(
                      '/dashboard/categorias/deshacer',
                      {
                          preserveScroll: true,
                      },
                  );
              },
          }
        : undefined;

    toast[toastPayload.type](toastPayload.title, {
        description: toastPayload.description,
        action,
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
    createForm.post('/dashboard/categorias', {
        preserveScroll: true,
        onSuccess: () => {
            createSheetOpen.value = false;
            createForm.reset();
        },
    });
};

const openEdit = (category: Category) => {
    selectedCategory.value = category;
    editForm.name = category.name;
    editForm.icon = category.icon;
    editForm.sort_order = category.sort_order;
    editSheetOpen.value = true;
};

const submitEdit = () => {
    if (!selectedCategory.value) {
        return;
    }

    editForm.put(`/dashboard/categorias/${selectedCategory.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            editSheetOpen.value = false;
            selectedCategory.value = null;
        },
    });
};

const openDelete = (category: Category) => {
    selectedCategory.value = category;
    deleteDialogOpen.value = true;
};

const submitDelete = () => {
    if (!selectedCategory.value) {
        return;
    }

    deleteForm.delete(`/dashboard/categorias/${selectedCategory.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            deleteDialogOpen.value = false;
            selectedCategory.value = null;
        },
    });
};

const columnHelper = createColumnHelper<Category>();

const sortableHeader = (label: string, columnId: keyof Category) => {
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
    columnHelper.accessor('icon', {
        header: () => sortableHeader('Icono', 'icon'),
        cell: (info) => info.getValue(),
    }),
    columnHelper.accessor('sort_order', {
        header: () => sortableHeader('Orden', 'sort_order'),
        cell: (info) => info.getValue(),
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
        return props.categories;
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

const visibleCategories = computed(() => visibleRows.value.length);

const categoriesTotal = computed(() => filteredRows.value.length);

const hasCategories = computed(() => table.getRowModel().rows.length > 0);
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
                        <h2 class="text-xl font-bold">Categorías</h2>
                        <p class="text-sm text-muted-foreground">
                            Gestiona las categorías del catálogo.
                        </p>
                    </div>

                    <Button @click="createSheetOpen = true">
                        Crear categoría
                    </Button>
                </div>

                <div class="mb-4 max-w-sm">
                    <Input
                        :model-value="
                            (table
                                .getColumn('name')
                                ?.getFilterValue() as string) ?? ''
                        "
                        placeholder="Buscar por nombre..."
                        @update:model-value="
                            table.getColumn('name')?.setFilterValue($event)
                        "
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
                                    :class="
                                        cell.column.id === 'name'
                                            ? 'font-medium'
                                            : ''
                                    "
                                >
                                    <FlexRender
                                        :render="cell.column.columnDef.cell"
                                        :props="cell.getContext()"
                                    />
                                </td>
                            </tr>

                            <tr v-if="!hasCategories">
                                <td
                                    :colspan="columns.length"
                                    class="py-6 text-center text-muted-foreground"
                                >
                                    No hay categorías disponibles.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center justify-between gap-4">
                    <p class="text-sm text-muted-foreground">
                        Mostrando {{ visibleCategories }} de
                        {{ categoriesTotal }} categorías.
                    </p>

                    <Button
                        v-if="canLoadMore"
                        variant="outline"
                        @click="loadMore"
                    >
                        Ver más
                    </Button>
                </div>
            </div>
        </div>

        <CreateCategorySheet
            v-if="createSheetOpen"
            v-model:open="createSheetOpen"
            :errors="createForm.errors"
            :form="createForm"
            :icon-options="props.iconOptions"
            :processing="createForm.processing"
            @submit="submitCreate"
        />

        <EditCategorySheet
            v-if="editSheetOpen"
            v-model:open="editSheetOpen"
            :errors="editForm.errors"
            :form="editForm"
            :icon-options="props.iconOptions"
            :processing="editForm.processing"
            @submit="submitEdit"
        />

        <DeleteCategoryDialog
            v-if="deleteDialogOpen"
            v-model:open="deleteDialogOpen"
            :category-name="selectedCategory?.name ?? null"
            :processing="deleteForm.processing"
            @confirm="submitDelete"
        />
    </AppLayout>
</template>
