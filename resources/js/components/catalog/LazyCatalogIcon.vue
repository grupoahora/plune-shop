<script setup lang="ts">
import { Sparkles } from 'lucide-vue-next';
import { shallowRef, watch } from 'vue';

const props = defineProps<{
    iconName: string;
}>();

const iconComponent = shallowRef(Sparkles);

watch(
    () => props.iconName,
    async () => {
        const icons = await import('lucide-vue-next');
        const icon = icons[props.iconName as keyof typeof icons];

        iconComponent.value = (icon as typeof Sparkles | undefined) ?? Sparkles;
    },
    {
        immediate: true,
    },
);
</script>

<template>
    <component :is="iconComponent" class="size-5" />
</template>
