<script setup lang="ts">
import ProductFormFields from '@/components/products/ProductFormFields.vue';
import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';

type ProductFormData = {
    name: string;
    description: string;
    product_code: string;
    price_sale: number;
    category_id: number | null;
    status: boolean;
};

type ProductFormErrors = Partial<Record<keyof ProductFormData, string>>;

const props = defineProps<{
    open: boolean;
    form: ProductFormData;
    errors: ProductFormErrors;
    processing: boolean;
    categories: Array<{ id: number; name: string }>;
}>();

const emit = defineEmits<{
    (event: 'update:open', value: boolean): void;
    (event: 'submit'): void;
    (event: 'update:name', value: string): void;
    (event: 'update:description', value: string): void;
    (event: 'update:productCode', value: string): void;
    (event: 'update:priceSale', value: number): void;
    (event: 'update:categoryId', value: number): void;
    (event: 'update:status', value: boolean): void;
}>();
</script>

<template>
    <Sheet :open="props.open" @update:open="emit('update:open', $event)">
        <SheetContent class="sm:max-w-lg">
            <SheetHeader>
                <SheetTitle>Nuevo producto</SheetTitle>
                <SheetDescription>
                    Agrega un nuevo producto al catálogo.
                </SheetDescription>
            </SheetHeader>

            <div class="mt-0 rounded-lg border border-border/80 bg-muted/20 p-4">
                <form class="grid gap-4" @submit.prevent="emit('submit')">
                    <ProductFormFields
                        id-prefix="create"
                        :categories="props.categories"
                        :errors="props.errors"
                        :form="props.form"
                        @update:category-id="emit('update:categoryId', $event)"
                        @update:description="emit('update:description', $event)"
                        @update:name="emit('update:name', $event)"
                        @update:price-sale="emit('update:priceSale', $event)"
                        @update:product-code="emit('update:productCode', $event)"
                        @update:status="emit('update:status', $event)"
                    />

                    <SheetFooter>
                        <Button :disabled="props.processing" type="submit">
                            Crear producto
                        </Button>
                    </SheetFooter>
                </form>
            </div>
        </SheetContent>
    </Sheet>
</template>
