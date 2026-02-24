<script setup lang="ts">
import CategoryFormFields from '@/components/categories/CategoryFormFields.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import type { CategoryFormData, CategoryFormErrors } from '@/pages/categories/types';

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

            <Card class="mt-6 gap-0 py-4 shadow-none">
                <CardContent>
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
                </CardContent>
            </Card>
        </SheetContent>
    </Sheet>
</template>
