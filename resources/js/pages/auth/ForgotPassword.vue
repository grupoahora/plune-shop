<script setup lang="ts">
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';

const email = ref('');
const errors = ref<Record<string, string>>({});
const processing = ref(false);
const status = ref('');

const handleSubmit = () => {
    processing.value = true;
    errors.value = {};
    // Mock: In a real app, call the API
    setTimeout(() => {
        processing.value = false;
        status.value = 'verification-link-sent';
    }, 500);
};
</script>

<template>
    <AuthLayout
        title="Forgot password"
        description="Enter your email to receive a password reset link"
    >
        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            A new verification link has been sent to the email address you provided.
        </div>

        <div class="space-y-6">
            <form @submit.prevent="handleSubmit">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        v-model="email"
                        autocomplete="off"
                        autofocus
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="my-6 flex items-center justify-start">
                    <Button
                        class="w-full"
                        :disabled="processing"
                        data-test="email-password-reset-link-button"
                    >
                        <Spinner v-if="processing" />
                        Email password reset link
                    </Button>
                </div>
            </form>

            <div class="space-x-1 text-center text-sm text-muted-foreground">
                <span>Or, return to</span>
                <TextLink href="/login">log in</TextLink>
            </div>
        </div>
    </AuthLayout>
</template>
