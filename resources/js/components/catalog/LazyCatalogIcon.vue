<script setup lang="ts">
import { computed } from 'vue';
import { resolveCategoryIcon } from '@/lib/category-icons';

const props = defineProps<{
    iconName: string;
}>();

const iconComponent = computed(() => resolveCategoryIcon(props.iconName));
</script>

<template>
    <component :is="iconComponent" class="size-5" />
</template>
