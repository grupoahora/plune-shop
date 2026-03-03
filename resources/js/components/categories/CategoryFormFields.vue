<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
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

const props = defineProps<{
    form: CategoryFormData;
    errors: CategoryFormErrors;
    idPrefix: string;
    iconOptions: string[];
}>();

const emit = defineEmits<{
    (event: 'update:name', value: string): void;
    (event: 'update:icon', value: string): void;
    (event: 'update:sortOrder', value: number): void;
}>();
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Información de categoría</CardTitle>
        </CardHeader>
        <CardContent class="grid gap-4">
            <div class="grid gap-2">
                <Label :for="`${props.idPrefix}-name`">Nombre</Label>
                <Input
                    :id="`${props.idPrefix}-name`"
                    :model-value="props.form.name"
                    type="text"
                    @update:model-value="emit('update:name', $event)"
                />
                <InputError :message="props.errors.name" />
            </div>

            <div class="grid gap-2">
                <Label :for="`${props.idPrefix}-icon`">Icono (permitidos)</Label>
                <div
                    :id="`${props.idPrefix}-icon`"
                    class="grid max-h-56 grid-cols-2 gap-2 overflow-y-auto rounded-md border border-input p-2 sm:grid-cols-3"
                >
                    <Button
                        v-for="iconName in props.iconOptions"
                        :key="iconName"
                        :class="cn(
                            'h-auto justify-start gap-2 px-2 py-1.5 text-left text-xs',
                            props.form.icon === iconName
                                ? 'border-primary bg-primary/10 text-primary hover:bg-primary/20'
                                : 'hover:bg-muted/60',
                        )"
                        :variant="props.form.icon === iconName ? 'outline' : 'ghost'"
                        type="button"
                        @click="emit('update:icon', iconName)"
                    >
                        <component
                            :is="resolveCategoryIcon(iconName)"
                            class="size-4"
                        />
                        <span class="truncate">{{ iconName }}</span>
                    </Button>
                </div>
                <InputError :message="props.errors.icon" />
            </div>

            <div class="grid gap-2">
                <Label :for="`${props.idPrefix}-order`">Orden</Label>
                <Input
                    :id="`${props.idPrefix}-order`"
                    :model-value="props.form.sort_order"
                    min="0"
                    type="number"
                    @update:model-value="emit('update:sortOrder', Number($event || 0))"
                />
                <InputError :message="props.errors.sort_order" />
            </div>
        </CardContent>
    </Card>
</template>
