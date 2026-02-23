<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Category {
    id: number;
    name: string;
    icon: string;
    sort_order: number;
}

const props = defineProps<{
    categories: Category[];
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

const createForm = useForm({
    name: '',
    icon: 'spa',
    sort_order: 0,
});

const editForm = useForm({
    name: '',
    icon: '',
    sort_order: 0,
});

const deleteForm = useForm({});

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
    if (!selectedCategory.value) return;

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
    if (!selectedCategory.value) return;

    deleteForm.delete(`/dashboard/categorias/${selectedCategory.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            deleteDialogOpen.value = false;
            selectedCategory.value = null;
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h2 class="text-xl font-bold">Categorías</h2>
                        <p class="text-sm text-muted-foreground">
                            Gestiona las categorías del catálogo.
                        </p>
                    </div>

                    <Sheet v-model:open="createSheetOpen">
                        <SheetTrigger as-child>
                            <Button>Crear categoría</Button>
                        </SheetTrigger>
                        <SheetContent>
                            <SheetHeader>
                                <SheetTitle>Nueva categoría</SheetTitle>
                                <SheetDescription>
                                    Agrega una nueva categoría para el catálogo.
                                </SheetDescription>
                            </SheetHeader>

                            <form class="grid gap-4 py-4" @submit.prevent="submitCreate">
                                <div class="grid gap-2">
                                    <Label for="create-name">Nombre</Label>
                                    <Input id="create-name" v-model="createForm.name" />
                                    <InputError :message="createForm.errors.name" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="create-icon">Icono (Material Symbol)</Label>
                                    <Input id="create-icon" v-model="createForm.icon" />
                                    <InputError :message="createForm.errors.icon" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="create-order">Orden</Label>
                                    <Input
                                        id="create-order"
                                        v-model.number="createForm.sort_order"
                                        min="0"
                                        type="number"
                                    />
                                    <InputError :message="createForm.errors.sort_order" />
                                </div>

                                <SheetFooter>
                                    <Button :disabled="createForm.processing" type="submit">Guardar</Button>
                                </SheetFooter>
                            </form>
                        </SheetContent>
                    </Sheet>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b text-left">
                                <th class="py-3">Nombre</th>
                                <th class="py-3">Icono</th>
                                <th class="py-3">Orden</th>
                                <th class="py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="category in props.categories"
                                :key="category.id"
                                class="border-b border-sidebar-border/60"
                            >
                                <td class="py-3 font-medium">{{ category.name }}</td>
                                <td class="py-3">{{ category.icon }}</td>
                                <td class="py-3">{{ category.sort_order }}</td>
                                <td class="py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button size="sm" variant="outline" @click="openEdit(category)">
                                            Editar
                                        </Button>
                                        <Button size="sm" variant="destructive" @click="openDelete(category)">
                                            Eliminar
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <Sheet v-model:open="editSheetOpen">
            <SheetContent>
                <SheetHeader>
                    <SheetTitle>Editar categoría</SheetTitle>
                    <SheetDescription>
                        Actualiza la información de la categoría.
                    </SheetDescription>
                </SheetHeader>

                <form class="grid gap-4 py-4" @submit.prevent="submitEdit">
                    <div class="grid gap-2">
                        <Label for="edit-name">Nombre</Label>
                        <Input id="edit-name" v-model="editForm.name" />
                        <InputError :message="editForm.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="edit-icon">Icono (Material Symbol)</Label>
                        <Input id="edit-icon" v-model="editForm.icon" />
                        <InputError :message="editForm.errors.icon" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="edit-order">Orden</Label>
                        <Input
                            id="edit-order"
                            v-model.number="editForm.sort_order"
                            min="0"
                            type="number"
                        />
                        <InputError :message="editForm.errors.sort_order" />
                    </div>

                    <SheetFooter>
                        <Button :disabled="editForm.processing" type="submit">Guardar cambios</Button>
                    </SheetFooter>
                </form>
            </SheetContent>
        </Sheet>

        <Dialog v-model:open="deleteDialogOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>¿Eliminar categoría?</DialogTitle>
                    <DialogDescription>
                        Esta acción eliminará
                        <strong>{{ selectedCategory?.name }}</strong>
                        de forma permanente.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" @click="deleteDialogOpen = false">Cancelar</Button>
                    <Button :disabled="deleteForm.processing" variant="destructive" @click="submitDelete">
                        Confirmar borrado
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
