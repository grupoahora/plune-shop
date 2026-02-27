<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

type CategoryFormData = {
    name: string;
    icon: string;
    sort_order: number;
};

type CategoryFormErrors = Partial<Record<keyof CategoryFormData, string>>;

defineProps<{
    form: CategoryFormData;
    errors: CategoryFormErrors;
    idPrefix: string;
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="`${idPrefix}-name`">Nombre</Label>
        <Input :id="`${idPrefix}-name`" v-model="form.name" />
        <InputError :message="errors.name" />
    </div>

    <div class="grid gap-2">
        <Label :for="`${idPrefix}-icon`">Icono (Lucide)</Label>
        <Input
            :id="`${idPrefix}-icon`"
            v-model="form.icon"
            placeholder="Ejemplo: Flower2"
        />
        <InputError :message="errors.icon" />
    </div>

    <div class="grid gap-2">
        <Label :for="`${idPrefix}-order`">Orden</Label>
        <Input
            :id="`${idPrefix}-order`"
            v-model.number="form.sort_order"
            min="0"
            type="number"
        />
        <InputError :message="errors.sort_order" />
    </div>
</template>
