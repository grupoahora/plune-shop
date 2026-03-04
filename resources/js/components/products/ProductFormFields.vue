<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

type ProductFormData = {
    name: string;
    description: string;
    product_code: string;
    image: string;
    price_sale: number;
    category_id: number | null;
    status: boolean;
};

type ProductFormErrors = Partial<Record<keyof ProductFormData, string>>;

defineProps<{
    form: ProductFormData;
    errors: ProductFormErrors;
    idPrefix: string;
    categories: Array<{ id: number; name: string }>;
}>();

const emit = defineEmits<{
    (event: 'update:name', value: string): void;
    (event: 'update:description', value: string): void;
    (event: 'update:productCode', value: string): void;
    (event: 'update:image', value: string): void;
    (event: 'update:priceSale', value: number): void;
    (event: 'update:categoryId', value: number): void;
    (event: 'update:status', value: boolean): void;
}>();
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Información de producto</CardTitle>
        </CardHeader>
        <CardContent class="grid gap-4">
            <div class="grid gap-2">
                <Label :for="`${idPrefix}-name`">Nombre</Label>
                <Input
                    :id="`${idPrefix}-name`"
                    :model-value="form.name"
                    type="text"
                    @update:model-value="emit('update:name', String($event))"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label :for="`${idPrefix}-description`">Descripción</Label>
                <Input
                    :id="`${idPrefix}-description`"
                    :model-value="form.description"
                    type="text"
                    @update:model-value="emit('update:description', String($event))"
                />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label :for="`${idPrefix}-image`">URL de imagen</Label>
                <Input
                    :id="`${idPrefix}-image`"
                    :model-value="form.image"
                    placeholder="https://..."
                    type="url"
                    @update:model-value="emit('update:image', String($event))"
                />
                <InputError :message="errors.image" />
            </div>

            <div class="grid gap-2 sm:grid-cols-2 sm:gap-4">
                <div class="grid gap-2">
                    <Label :for="`${idPrefix}-code`">Código</Label>
                    <Input
                        :id="`${idPrefix}-code`"
                        :model-value="form.product_code"
                        type="text"
                        @update:model-value="emit('update:productCode', String($event))"
                    />
                    <InputError :message="errors.product_code" />
                </div>

                <div class="grid gap-2">
                    <Label :for="`${idPrefix}-price`">Precio</Label>
                    <Input
                        :id="`${idPrefix}-price`"
                        :model-value="form.price_sale"
                        min="0"
                        step="0.01"
                        type="number"
                        @update:model-value="emit('update:priceSale', Number($event || 0))"
                    />
                    <InputError :message="errors.price_sale" />
                </div>
            </div>

            <div class="grid gap-2 sm:grid-cols-2 sm:gap-4">
                <div class="grid gap-2">
                    <Label :for="`${idPrefix}-category`">Categoría</Label>
                    <Select
                        :model-value="form.category_id === null ? '' : String(form.category_id)"
                        @update:model-value="emit('update:categoryId', Number($event))"
                    >
                        <SelectTrigger :id="`${idPrefix}-category`">
                            <SelectValue placeholder="Selecciona una categoría" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="category in categories"
                                :key="category.id"
                                :value="String(category.id)"
                            >
                                {{ category.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="errors.category_id" />
                </div>

                <div class="grid gap-2">
                    <Label :for="`${idPrefix}-status`">Estado</Label>
                    <Select
                        :model-value="form.status ? '1' : '0'"
                        @update:model-value="emit('update:status', $event === '1')"
                    >
                        <SelectTrigger :id="`${idPrefix}-status`">
                            <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="1">Activo</SelectItem>
                            <SelectItem value="0">Inactivo</SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="errors.status" />
                </div>
            </div>
        </CardContent>
    </Card>
</template>
