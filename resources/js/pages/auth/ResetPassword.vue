<script setup lang="ts">
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';

const route = useRoute();
const router = useRouter();

const token = route.params.token as string;
const inputEmail = ref((route.query.email as string) || '');

const form = ref({
    password: '',
    password_confirmation: '',
});

const errors = ref<Record<string, string>>({});
const processing = ref(false);

const handleSubmit = () => {
    processing.value = true;
    errors.value = {};
    // Mock: In a real app, call the API
    setTimeout(() => {
        processing.value = false;
        router.push('/login');
    }, 500);
};
</script>

<template>
    <AuthLayout
        title="Reset password"
        description="Please enter your new password below"
    >
        <form @submit.prevent="handleSubmit">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        autocomplete="email"
                        v-model="inputEmail"
                        class="mt-1 block w-full"
                        readonly
                    />
                    <InputError :message="errors.email" class="mt-2" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        v-model="form.password"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        autofocus
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">
                        Confirm Password
                    </Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder="Confirm password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    :disabled="processing"
                    data-test="reset-password-button"
                >
                    <Spinner v-if="processing" />
                    Reset password
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>
