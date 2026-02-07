<script setup lang="ts">
import { useRoute } from 'vue-router';
import { computed, watch } from 'vue';

const route = useRoute();

const appName = import.meta.env.VITE_APP_NAME || 'Plune Shop';

const pageTitle = computed(() => {
    const title = route.meta.title as string | undefined;
    return title ? `${title} - ${appName}` : appName;
});

watch(pageTitle, (newTitle) => {
    document.title = newTitle;
}, { immediate: true });
</script>

<template>
    <router-view />
</template>
