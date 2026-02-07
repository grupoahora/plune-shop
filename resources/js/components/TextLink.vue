<script setup lang="ts">
import { RouterLink } from 'vue-router';
import { computed } from 'vue';

type Props = {
    href: string;
    tabindex?: number;
    as?: string;
};

const props = defineProps<Props>();

const isExternal = computed(() =>
    props.href.startsWith('http') || props.href.startsWith('//'),
);
</script>

<template>
    <a
        v-if="isExternal || as === 'button'"
        :href="href"
        :tabindex="tabindex"
        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
    >
        <slot />
    </a>
    <RouterLink
        v-else
        :to="href"
        :tabindex="tabindex"
        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
    >
        <slot />
    </RouterLink>
</template>
