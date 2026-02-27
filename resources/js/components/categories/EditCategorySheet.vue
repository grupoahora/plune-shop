<script setup lang="ts">
import CategoryFormFields from '@/components/categories/CategoryFormFields.vue';
import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';

type CategoryFormData = {
    name: string;
    icon: string;
    sort_order: number;
};

type CategoryFormErrors = Partial<Record<keyof CategoryFormData, string>>;

const props = defineProps<{
    open: boolean;
    form: CategoryFormData;
    errors: CategoryFormErrors;
    processing: boolean;
    iconOptions: string[];
}>();

const emit = defineEmits<{
    (event: 'update:open', value: boolean): void;
    (event: 'submit'): void;
}>();
</script>

<template>
    <Sheet :open="props.open" @update:open="emit('update:open', $event)">
        <SheetContent>
            <SheetHeader>
                <SheetTitle>Editar categoría</SheetTitle>
                <SheetDescription>
                    Actualiza la información de la categoría.
                </SheetDescription>
            </SheetHeader>

            <div class="mt-6 rounded-lg border border-border/80 bg-muted/20 p-4">
                <form class="grid gap-4" @submit.prevent="emit('submit')">
                    <CategoryFormFields
                        id-prefix="edit"
                        :errors="props.errors"
                        :form="props.form"
                        :icon-options="props.iconOptions"
                    />

                    <SheetFooter>
                        <Button :disabled="props.processing" type="submit"
                            >Guardar cambios</Button
                        >
                    </SheetFooter>
                </form>
            </div>
        </SheetContent>
    </Sheet>
</template>
