<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { resolveCategoryIcon } from '@/lib/category-icons';
import { cn } from '@/lib/utils';

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
    iconOptions: string[];
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="`${idPrefix}-name`">Nombre</Label>
        <Input
            :id="`${idPrefix}-name`"
            v-model="form.name"
            type="text"
        />
        <InputError :message="errors.name" />
    </div>

    <div class="grid gap-2">
        <Label :for="`${idPrefix}-icon`">Icono (permitidos)</Label>
        <div
            :id="`${idPrefix}-icon`"
            class="grid max-h-56 grid-cols-2 gap-2 overflow-y-auto rounded-md border border-input p-2 sm:grid-cols-3"
        >
            <button
                v-for="iconName in iconOptions"
                :key="iconName"
                :class="cn(
                    'flex items-center gap-2 rounded-md border px-2 py-1.5 text-left text-xs transition-colors',
                    form.icon === iconName
                        ? 'border-primary bg-primary/10 text-primary'
                        : 'border-border hover:bg-muted/60',
                )"
                type="button"
                @click="form.icon = iconName"
            >
                <component :is="resolveCategoryIcon(iconName)" class="size-4" />
                <span class="truncate">{{ iconName }}</span>
            </button>
        </div>
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
