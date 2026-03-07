<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { type DeleteCategoryDialogProps } from '@/types/categories';
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';

const props = defineProps<DeleteCategoryDialogProps>();

const emit = defineEmits<{
    (event: 'update:open', value: boolean): void;
}>();

const closeDialog = (): void => {
    emit('update:open', false);
};
</script>

<template>
    <Dialog :open="props.open" @update:open="emit('update:open', $event)">
        <DialogContent>
            <Form
                v-bind="CategoryController.destroy(props.category.id).form()"
                reset-on-success
                @success="closeDialog"
                v-slot="{ processing }"
            >
                <DialogHeader>
                    <DialogTitle>¿Eliminar categoría?</DialogTitle>
                    <DialogDescription>
                        Esta acción eliminará
                        <strong>{{ props.category.name }}</strong>
                        de forma permanente.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button
                        variant="outline"
                        type="button"
                        @click="closeDialog"
                    >
                        Cancelar
                    </Button>
                    <Button
                        :disabled="processing"
                        variant="destructive"
                        type="submit"
                    >
                        Confirmar borrado
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
