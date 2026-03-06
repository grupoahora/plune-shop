<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { resolveCategoryIcon } from '@/lib/category-icons';
import { cn } from '@/lib/utils';
import { type CreateCategorySheetProps } from '@/types/categories';
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';

const props = defineProps<CreateCategorySheetProps>();

const emit = defineEmits<{
    (event: 'update:open', value: boolean): void;
}>();

const selectedIcon = ref('Flower2');

const closeSheet = (): void => {
    emit('update:open', false);
};
</script>

<template>
    <Sheet :open="props.open" @update:open="emit('update:open', $event)">
        <SheetContent>
            <SheetHeader class="pb-0">
                <SheetTitle>Nueva categoría</SheetTitle>
                <SheetDescription>
                    Agrega una nueva categoría para el catálogo.
                </SheetDescription>
            </SheetHeader>

            <div
                class="mt-0 rounded-lg border border-border/80 bg-muted/20 p-4"
            >
                <Form
                    v-bind="CategoryController.store.form()"
                    reset-on-success
                    class="grid gap-4"
                    @success="closeSheet"
                    v-slot="{ errors, processing }"
                >
                    <Card>
                        <CardHeader>
                            <CardTitle>Información de categoría</CardTitle>
                        </CardHeader>
                        <CardContent class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="create-name">Nombre</Label>
                                <Input
                                    id="create-name"
                                    name="name"
                                    type="text"
                                    placeholder="Nombre de la categoría"
                                />
                                <InputError :message="errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="create-icon"
                                    >Icono (permitidos)</Label
                                >
                                <input
                                    type="hidden"
                                    name="icon"
                                    :value="selectedIcon"
                                />
                                <div
                                    id="create-icon"
                                    class="grid max-h-56 grid-cols-2 gap-2 overflow-y-auto rounded-md border border-input p-2 sm:grid-cols-3"
                                >
                                    <Button
                                        v-for="iconName in props.iconOptions"
                                        :key="iconName"
                                        :class="
                                            cn(
                                                'h-auto justify-start gap-2 px-2 py-1.5 text-left text-xs',
                                                selectedIcon === iconName
                                                    ? 'border-primary bg-primary/10 text-primary hover:bg-primary/20'
                                                    : 'hover:bg-muted/60',
                                            )
                                        "
                                        :variant="
                                            selectedIcon === iconName
                                                ? 'outline'
                                                : 'ghost'
                                        "
                                        type="button"
                                        @click="selectedIcon = iconName"
                                    >
                                        <component
                                            :is="resolveCategoryIcon(iconName)"
                                            class="size-4"
                                        />
                                        <span class="truncate">{{
                                            iconName
                                        }}</span>
                                    </Button>
                                </div>
                                <InputError :message="errors.icon" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="create-order">Orden</Label>
                                <Input
                                    id="create-order"
                                    name="sort_order"
                                    min="0"
                                    type="number"
                                    value="0"
                                />
                                <InputError :message="errors.sort_order" />
                            </div>
                        </CardContent>
                    </Card>

                    <SheetFooter>
                        <Button :disabled="processing" type="submit"
                            >Guardar</Button
                        >
                    </SheetFooter>
                </Form>
            </div>
        </SheetContent>
    </Sheet>
</template>
