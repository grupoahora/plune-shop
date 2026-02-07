<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const processing = ref(false);
const status = ref('');

const handleResend = () => {
    processing.value = true;
    // Mock: In a real app, call the API
    setTimeout(() => {
        processing.value = false;
        status.value = 'verification-link-sent';
    }, 500);
};

const handleLogout = () => {
    authStore.logout();
    router.push('/login');
};
</script>

<template>
    <AuthLayout
        title="Verify email"
        description="Please verify your email address by clicking on the link we just emailed to you."
    >
        <div
            v-if="status === 'verification-link-sent'"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <div class="space-y-6 text-center">
            <Button :disabled="processing" variant="secondary" @click="handleResend">
                <Spinner v-if="processing" />
                Resend verification email
            </Button>

            <button
                @click="handleLogout"
                class="mx-auto block text-sm text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
            >
                Log out
            </button>
        </div>
    </AuthLayout>
</template>
