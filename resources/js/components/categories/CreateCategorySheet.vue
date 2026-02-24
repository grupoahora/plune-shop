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
                <SheetTitle>Nueva categoría</SheetTitle>
                <SheetDescription>
                    Agrega una nueva categoría para el catálogo.
                </SheetDescription>
            </SheetHeader>

            <div
                class="mt-6 rounded-lg border border-border/80 bg-muted/20 p-4"
            >
                <form class="grid gap-4" @submit.prevent="emit('submit')">
                    <CategoryFormFields
                        id-prefix="create"
                        :errors="props.errors"
                        :form="props.form"
                    />

                    <SheetFooter>
                        <Button :disabled="props.processing" type="submit"
                            >Guardar</Button
                        >
                    </SheetFooter>
                </form>
            </div>
        </SheetContent>
    </Sheet>
</template>
