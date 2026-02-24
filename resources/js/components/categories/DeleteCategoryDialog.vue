<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

const props = defineProps<{
    open: boolean;
    categoryName: string | null;
    processing: boolean;
}>();

const emit = defineEmits<{
    (event: 'update:open', value: boolean): void;
    (event: 'confirm'): void;
}>();
</script>

<template>
    <Dialog :open="props.open" @update:open="emit('update:open', $event)">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>¿Eliminar categoría?</DialogTitle>
                <DialogDescription>
                    Esta acción eliminará
                    <strong>{{ props.categoryName }}</strong>
                    de forma permanente.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button variant="outline" @click="emit('update:open', false)">
                    Cancelar
                </Button>
                <Button
                    :disabled="props.processing"
                    variant="destructive"
                    @click="emit('confirm')"
                >
                    Confirmar borrado
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
